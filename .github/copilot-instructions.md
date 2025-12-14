Project-specific Copilot instructions

Summary
- This is a small PHP web project (driving school) with most source code in `src/` and public endpoints in `public/`.
- Tests use PHPUnit and live under `tests/`. A `phpunit.xml.dist` exists at repository root.

Key facts for AI agents
- The project uses `composer.json` with a PSR-4 section (`Webt\\Drivingschool\\` -> `src/`), but most PHP files in `src/` have no PHP namespace declarations (global namespace). Do not assume PSR-4 autoloading will locate those classes — tests and quick edits often `require_once` the raw files.
- Primary domain objects: `src/Course.php`, `src/Question.php`, `src/CarTheoryQuestion.php`, `src/MotorcycleTheoryQuestion.php` — they implement `JsonSerializable` and expose simple getters/setters.
- Public API surface: files in `public/` (for example `public/getCourse.php`, `public/getCourses.php`, `public/token.php`) are lightweight endpoints that instantiate `src/` classes and return JSON. Treat them as integration points when editing domain logic.
- Security helpers are in `src/security/` (`JwtAuth.php`, `JwtService.php`) — changes here affect protected endpoints; be careful when modifying JWT behavior.
- Third-party dependency: `endroid/qr-code` is used; dev dependency `phpunit/phpunit` exists in `require-dev`.

Testing and developer workflow
- Run `composer install` before running tests so `vendor/autoload.php` is available.
- Run tests locally with the project-provided PHPUnit (from vendor):

```bash
composer install
./vendor/bin/phpunit --configuration phpunit.xml.dist
```

- On Windows PowerShell, run the vendor binary like:

```powershell
vendor\\bin\\phpunit --configuration phpunit.xml.dist
```

- Because source files are not namespaced, test files typically `require_once __DIR__ . '/../src/SomeFile.php'` and also include `vendor/autoload.php`. When you convert a class to a namespace, update `composer.json` and run `composer dump-autoload`.

Project conventions and patterns
- Domain classes are simple POPOs (plain PHP objects) with `get/set` methods and `jsonSerialize()` for JSON output — tests should assert both state via getters and output via `json_encode($obj)`.
- Tests live in `tests/` and should follow PHPUnit naming: `SomethingTest.php` and class `SomethingTest extends PHPUnit\\Framework\\TestCase`.
- Use fixture setup inside test methods or `setUp()` fixtures. The project expects tests to include positive, negative, and edge cases.
- Use at least three different PHPUnit assertions across the suite (e.g., `assertEquals`, `assertTrue`, `assertCount`).

Integration points to watch
- `public/*.php` files (example: `public/getCourse.php`) — quick integration tests can call these scripts (via HTTP or CLI) to assert JSON shape.
- `src/security/*` — changing JWT signature, claims, or expiry impacts tokens issued by `public/token.php`.

Small examples (how to write tests here)
- Example: test `src/Course.php` by requiring the file directly, constructing a `Course`, adding `Question` objects (from `src/Question.php`), asserting getters and `jsonSerialize()`:

- See `tests/CourseTest.php` (added) as a working reference.

Tips for code changes
- Preserve existing file-level style: many files use German comments and no namespaces; keep changes minimal unless you intend a larger refactor.
- If you add namespaces, update `composer.json` and use `composer dump-autoload` — run the test suite immediately after.
- Avoid changing public endpoint input/output shapes without updating callers and tests (search `public/` for usage).

If anything here is unclear or you'd like stricter rules (naming conventions, coverage thresholds, CI integration), tell me which area to expand.
