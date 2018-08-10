Readme
=====
1 - Install the bundle
``` bash
composer require adamwjtk/some-example-bundles
```
2 - Enable the bundles in the kernel:

``` php
    public function registerBundles()
    {
        $bundles = [

            new \AdamwjtkProductBundle\AdamwjtkProductBundle(),
            new \AdamwjtkClientBundle\AdamwjtkClientBundle(),
            
        ];
```

3 - register the routes

```yaml
# app/config/routing.yml

adamwjtk_client:
    resource: "@AdamwjtkClientBundle/Resources/config/routing.yml"
    prefix: /client

adamwjtk_product:
    resource: "@AdamwjtkProductBundle/Resources/config/routing.yml"
    prefix:   /api/v1/product
```

4 - register services

``` yaml
# app/config/services.yml

    AdamwjtkProductBundle\:
      resource: '../../src/Adamwjtk/ProductBundle/*'
      exclude: '../../src/Adamwjtk/ProductBundle/{Entity,Repository,Tests}'
```

```yaml
# app/config/config.yml
imports:

    - { resource: "@AdamwjtkProductBundle/Resources/config/services.yml"} 
```

5 - move assets from \vendor\adamwjtk\some-example-bundles\src\Adamwjtk\ClientBundle\Resources\public to \web and set up
config.yml like this :
``` yaml
twig:
    //.....
    form_themes:
      - bootstrap_3_layout.html.twig
```

6 - update db
``` bash
  php bin/console doctrine:schema:update --force
```



7 - run 
``` yml
{your.domain}/app_dev.php/client/list
```
