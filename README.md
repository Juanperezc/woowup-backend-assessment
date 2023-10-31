
# Email Failover Service with Queue Support and Captcha

## About

This service is designed to provide a seamless integration between multiple email service providers, specifically SendGrid and Mailgun. Built on Laravel, the service features a RESTful API that accepts the necessary email details, and places them into a job queue to be processed asynchronously. In the event of a service failure with one provider, the service will automatically failover to another provider. For added security, a Google reCAPTCHA validation is also integrated.

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

### Deployment

This application can be easily deployed using Docker containers, as set up with Laravel Sail.

## API Documentation

Please refer to `APIdocs` for a detailed description of API endpoints and their usage.

## Contributing

For guidelines on contributing to this project, please read [CONTRIBUTING.md](CONTRIBUTING.md).

## Review Guidelines

[Guidelines for review can be found here](https://github.com/woowup/challenge-backend-senior/blob/main/REVIEW.md)

## License

This project is licensed under the [MIT license](https://opensource.org/licenses/MIT).
