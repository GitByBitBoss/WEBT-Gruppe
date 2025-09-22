markdown
# Driving School Learning Platform – DriveWell | Development Environment Setup

## Definition of Done
A user story is considered **Done** when all of the following criteria are met:

- All acceptance criteria for the user story are fully implemented and verified
- The Docker container(s) start successfully without errors
- No orphaned containers, networks, or volumes remain after cleanup

## User Story 1
*As a learning platform IT specialist, I want to create a Docker container running the learning platform, so that I can have a consistent local development environment without installing the platform directly on our systems.*

### Acceptance Criteria
- Default platform page is accessible via "http://localhost"

## User Story 2
*As a learning platform IT specialist, I want to configure a custom virtual host "dev.drivewell.local" in my Docker container, so that I can access our development platform using a meaningful domain name.*

### Acceptance Criteria
- "http://dev.drivewell.local" serves content from the virtual host

## User Story 3
*As a learning platform IT specialist, I want to create a welcome HTML page for my virtual host, so that I can verify the setup is working correctly and have a starting point for platform development.*

### Acceptance Criteria
- A Welcome page is correctly displayed when accessing "http://dev.drivewell.local"

## User Story 4
*As a learning platform IT specialist, I want to enable live file editing in my Docker development environment, so that I can modify our platform files locally and see changes without rebuilding the container.*

### Acceptance Criteria
- Changes made to local HTML/CSS/JS files are visible in the browser after refreshing

## User Story 5
*As a learning platform IT specialist, I want to use Docker Compose to manage our platform development environment, so that I can easily start, stop, and rebuild our platform setup.*

### Acceptance Criteria
- The development environment can be managed using docker compose commands, e.g. up, down, start and stop
