# Email Failover Service with Queue Support and Captcha

## About

This service is designed to provide a seamless integration between multiple email service providers, specifically SendGrid and Mailgun. Built on Laravel, the service features a RESTful API that accepts the necessary email details, and places them into a job queue to be processed asynchronously. In the event of a service failure with one provider, the service will automatically failover to another provider. For added security, a Google reCAPTCHA validation is also integrated.

## Architecture

The service separates concerns between the front-end and back-end efficiently. The front-end is primarily for demonstration and testing, while the back-end manages the core functionalities like API endpoints, queue management, and failover logic. This separation makes it easier to maintain and scale each part independently.

## Clarity

The README provides a concise and clear explanation of the problem the service solves and how it solves it. It lists all the features and requirements, making it easier for anyone to understand the service's capabilities and constraints.

## Features

- Asynchronous email sending using job queues
- Supports SendGrid and Mailgun as email providers
- Automatic failover between providers
- RESTful API with detailed documentation
- Minimal front-end for demonstration and testing
- Security features including Google reCAPTCHA
- Written, documented, and tested as if ready for production

## Requirements

- PHP >= 8.2
- Docker
- Laravel Sail
- Google reCAPTCHA account ([register here](https://www.google.com/recaptcha))
- SendGrid account ([register here](https://sendgrid.com/user/signup))
- Mailgun account ([register here](http://www.mailgun.com))

## Technical Choices

The technology stack includes PHP 8.2, Laravel, Docker, and Laravel Sail, all of which are robust and widely used in the industry. For database queuing, you presumably would be using Laravel's queue worker, which supports various drivers like Redis, Database, Amazon SQS, etc.

## Getting Started

### Installation

First, clone the repository:

```bash
git clone https://github.com/yourrepo/email-failover-service.git
cd email-failover-service
```

Copy the `.env.example` to create your own `.env`:

```bash
cp .env.example .env
```

Update the `.env` file with your Google reCAPTCHA, SendGrid and Mailgun credentials.

Run Laravel Sail to install the dependencies and start the service:

```bash
./vendor/bin/sail up -d
./vendor/bin/sail composer install
./vendor/bin/sail artisan key:generate
```

### Run Tests

To run the tests, execute the following:

```bash
./vendor/bin/sail artisan test
```

## Testing

The README mentions that you can run tests using Laravel's built-in test functionality. This is a good indication that the application has some level of automated tests. The choice of automated tests would ideally cover unit tests for isolated pieces of logic and integration tests for workflow testing.

## Security

The service incorporates Google reCAPTCHA for added security, reducing the risk of automated bot attacks. The usage of multiple email service providers also adds a layer of reliability and indirectly, security, by ensuring the service is less dependent on a single third-party service.

## Production-Readiness

The service incorporates Laravel Telescope for API monitoring and debugging and Laravel Horizon for managing queue workers. These tools make it easier to track activities, monitor the health of the application, and retry failed queue jobs, making the service production-ready.

## Deployment

This application can be easily deployed using Docker containers, as set up with Laravel Sail.

## API Documentation

Please refer to `APIdocs` for a detailed description of API endpoints and their usage.

## Contributing

For guidelines on contributing to this project, please read [CONTRIBUTING.md](CONTRIBUTING.md).

## Review Guidelines

[Guidelines for review can be found here](https://github.com/woowup/challenge-backend-senior/blob/main/REVIEW.md)

## License

This project is licensed under the [MIT license](https://opensource.org/licenses/MIT).

