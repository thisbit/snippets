# WordPress ACF Search Extension

WARNING: this was made for personal use, and tested only in singular enviornment and usecase, use at your own peril :) 

A lightweight, high-performance extension for WordPress that enhances the default search functionality to include content stored in Advanced Custom Fields (ACF).

## Overview

The ACF Search Extension improves WordPress search by including ACF field content in search results, making your site's custom content discoverable through the standard WordPress search. It's designed with performance and security in mind, featuring efficient caching, targeted ACF field selection, and comprehensive error handling.

## Features

- **ACF Content Searchability**: Makes content stored in ACF fields discoverable through WordPress search
- **Performance Optimized**: Implements efficient caching to minimize database load
- **Security Focused**: Properly sanitizes inputs and handles errors gracefully
- **Developer Friendly**: Offers filter hooks for customization and extension
- **LiteSpeed Cache Compatible**: Works seamlessly with LiteSpeed server environments
- **Zero Configuration**: Works out of the box with sensible defaults

## Installation

1. Copy the `apuri-acf-search.php` file to your theme's directory or create a custom plugin
2. Include the file in your theme's `functions.php` or activate your custom plugin

```php
// If adding to functions.php
require_once get_template_directory() . '/apuri-acf-search.php';
```

## Usage

Once installed, the extension works automatically with no configuration required. When users search your site, the search results will include posts that have matching content in ACF fields.

### Disabling the Extension

You can disable the extension by defining a constant in your `wp-config.php` file:

```php
define('APURI_DISABLE_ACF_SEARCH', true);
```

## Customization

The extension provides several filter hooks for customization:

### Excluding Meta Keys

You can modify which meta keys are excluded from search:

```php
add_filter('apuri_search_excluded_meta_keys', function($excluded_keys) {
    // Add additional meta keys to exclude
    $excluded_keys[] = 'my_excluded_meta_key';
    return $excluded_keys;
});
```

### Excluding Sensitive ACF Fields

Exclude sensitive fields that shouldn't be searchable:

```php
add_filter('apuri_search_sensitive_acf_fields', function($sensitive_fields) {
    // Add sensitive ACF fields to exclude
    $sensitive_fields[] = 'password_field';
    $sensitive_fields[] = 'secret_api_key';
    return $sensitive_fields;
});
```

### Adjusting Meta Limit

Control how many meta rows per post are considered during search:

```php
add_filter('apuri_search_meta_limit', function($limit) {
    // Increase or decrease the limit (default is 50)
    return 100;
});
```

### Adjusting Cache Duration

Control how long search results are cached:

```php
add_filter('apuri_search_cache_duration', function($duration) {
    // Set cache duration to 3 days (259200 seconds)
    return 3 * DAY_IN_SECONDS;
});
```

The default cache duration is 24 hours (86400 seconds). WordPress provides several constants for time periods:
- `MINUTE_IN_SECONDS` (60 seconds)
- `HOUR_IN_SECONDS` (3600 seconds)
- `DAY_IN_SECONDS` (86400 seconds)
- `WEEK_IN_SECONDS` (604800 seconds)
- `MONTH_IN_SECONDS` (2592000 seconds)
- `YEAR_IN_SECONDS` (31536000 seconds)

## Performance Considerations

The extension includes several performance optimizations:

1. **Transient Caching**: Search results are cached for 24 hours by default to reduce database load
2. **ACF Field Targeting**: Only non-system meta fields are searched (typically ACF fields)
3. **Group By**: Uses efficient GROUP BY operation instead of DISTINCT for result deduplication
4. **Hook Management**: Only attaches filters when needed and removes them after use
5. **LiteSpeed Integration**: Automatically clears LiteSpeed cache when relevant content changes

## Technical Details

### Database Impact

The extension works by modifying WordPress search queries in the following ways:

1. Adds a LEFT JOIN to the postmeta table
2. Modifies the WHERE clause to include ACF field content
3. Uses GROUP BY to prevent duplicate results
4. Caches results to minimize database load

### Cache Invalidation

The search cache is automatically cleared when:

- Posts are saved or deleted
- Post meta is added, updated, or deleted

If you're using LiteSpeed Cache, the extension will also purge the LiteSpeed cache when content changes.

## Compatibility

- **WordPress**: Tested with WordPress 5.8+ (should work with 5.0+)
- **PHP**: Requires PHP 7.0+
- **Advanced Custom Fields**: Compatible with ACF 5.0+
- **LiteSpeed Cache**: Fully compatible with LiteSpeed Server and LiteSpeed Cache

## Troubleshooting

### Search Not Including ACF Content

1. Verify that the extension is not disabled via the `APURI_DISABLE_ACF_SEARCH` constant
2. Check WordPress debug logs for any error messages
3. Ensure ACF fields are public and not excluded via the filter hooks

### Performance Issues

If you experience performance issues on sites with many posts and meta entries:

1. Decrease the meta limit using the `apuri_search_meta_limit` filter
2. Add more specific exclusions for meta keys you don't want to search
3. Consider adjusting the cache duration using the `apuri_search_cache_duration` filter

## License

This extension is released under the MIT License.

## Credits

Developed by [Your Name/Organization]

---

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Support

For support, please open an issue on the GitHub repository or contact [your contact information].
