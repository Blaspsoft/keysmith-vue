# Keysmith Vue

[![Latest Version on Packagist](https://img.shields.io/packagist/v/modla/keysmith-vue.svg?style=flat-square)](https://packagist.org/packages/modla/keysmith-vue)
[![Total Downloads](https://img.shields.io/packagist/dt/modla/keysmith-vue.svg?style=flat-square)](https://packagist.org/packages/modla/keysmith-vue)
![GitHub Actions](https://github.com/modla/keysmith-vue/actions/workflows/main.yml/badge.svg)

Keysmith Vue is a Laravel package that provides Vue.js components for managing API keys and tokens in your application. It offers a clean, user-friendly interface for creating, viewing, and revoking API keys with customizable permissions.

## Installation

You can install the package via composer:

```bash
composer require modla/keysmith-vue
```

After installation, publish the package assets and configuration:

```bash
php artisan vendor:publish --provider="Modla\KeysmithVue\KeysmithVueServiceProvider"
```

## Usage

### Basic Setup

1. Include the Keysmith Vue components in your Vue application:

```javascript
import KeysmithManager from "keysmith-vue";

export default {
  components: {
    KeysmithManager,
  },
};
```

2. Add the component to your template:

```html
<keysmith-manager :endpoint="/api/keys" :user-id="1" />
```

### Available Props

- `endpoint`: The API endpoint for key management (required)
- `user-id`: The ID of the user managing the keys (required)
- `permissions`: Array of available permissions (optional)
- `theme`: Custom theme settings (optional)

### Events

The component emits several events you can listen to:

```html
<keysmith-manager
  @key-created="handleNewKey"
  @key-revoked="handleRevocation"
  @error="handleError"
/>
```

### Customizing the UI

You can customize the appearance by passing a theme object:

```html
<keysmith-manager
  :theme="{
        primary: '#4A90E2',
        secondary: '#F5F5F5',
        danger: '#E53E3E'
    }"
/>
```

### Backend Integration

The package automatically sets up the necessary routes and controllers. Make sure your API authentication middleware is configured correctly in your Laravel application.

## Configuration

You can modify the package behavior by updating the published configuration file:

```php
// config/keysmith.php
return [
    'token_expiration' => 7200,
    'max_tokens' => 10,
    'permissions' => [
        'read',
        'write',
        'delete'
    ]
];
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email mike.deeming@blaspsoft.com instead of using the issue tracker.

## Credits

- [Michael Deeming](https://github.com/modla)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
