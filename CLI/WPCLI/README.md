# Post WordPress Install Cleanup/Setup Script
To be used with terminal

## all at once
- `wp theme install intentionally-blank && wp theme activate intentionally-blank && wp theme delete --all && wp plugin delete --all && wp plugin install builderius /home/ek/Downloads/builderius-pro-0.10.0.zip advanced-custom-fields custom-post-type-ui && wp plugin activate --all && wp post delete $(wp post list --post_type='post' --format=ids) && wp post delete $(wp post list --post_status=trash --format=ids) && curl -N https://loripsum.net/api/10/short/headers/decorate/ul/link/bq/ | wp post generate --count=10 --post_type=post --post_content --post_title="Some post titles for demos" && wp media import /home/ek/Pictures/demos/*.jpg`

## Command parts
### installs & activates desired theme and removes default ones
- `wp theme install intentionally-blank`
- `wp theme activate intentionally-blank`
- `wp theme delete --all`

### removes default plugins & and installes and activates desired ones
- `wp plugin delete --all`
- `wp plugin install builderius /home/ek/Downloads/builderius-pro-0.10.0.zip advanced-custom-fields custom-post-type-ui`
- `wp plugin activate --all`

### removes any default posts and epties the trash & genenerates 10 new ones from api
- `wp post delete $(wp post list --post_type='post' --format=ids)`
- `wp post delete $(wp post list --post_status=trash --format=ids)`
- `curl -N https://loripsum.net/api/10/short/headers/decorate/ul/link/bq/ | wp post generate --count=10 --post_type=post --post_content --post_title="Some post titles for demos"`

### adds all jpg images from local "demos" folder
- `wp media import /home/ek/Pictures/demos/*.jpg`

Enjoy