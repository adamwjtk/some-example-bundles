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
    resource: "@AdamwjtkProductBundle/Controller/"
    type: annotation
    prefix:   /api/v1/product
```

4 - move assets from \vendor\adamwjtk\some-example-bundles\src\Adamwjtk\ClientBundle\Resources\public to \web

5 - update db
``` bash
  php bin/console doctrine:schema:update --force
```
