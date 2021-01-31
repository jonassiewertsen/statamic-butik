---
description: 'If you want to provide a search, there are multiple ways'
---

# Search

 Because products are a native collection, we can make use of the search functionality by Statamic:  
[https://statamic.dev/search](https://statamic.dev/search)

### Default Search

Set up a search form in your antlers template, define a template for the results and you are finished. 

[https://statamic.dev/search](https://statamic.dev/search#search-forms)

### Live Search

What about a live search? Well, lucky I did create an addon for this case. 

It provides updated results as you type but is hooking into the Statamic search as well.  
Use the local driver, an algolia driver or whatever you prefer. 

![Live Search - A Statamic addon](../.gitbook/assets/statamic-live-serach.gif)

{% embed url="https://statamic.com/addons/jonassiewertsen/live-search" %}

### Configure indexes

Whatever way you prefer, the main key is to configure those search indexes correctly.   
  
An example to get you started. Here we do have the default index for the page itself and a separate index for products. In your search you can leave out the index to serach through all indexes or define 

`default` or `products` as index, to narrow down the search results.

```text
// config/statamic/search.php

'default' => [
   'driver' => 'local',
   'searchables' => ['collection:pages'],
   'fields' => ['title', 'url' ],
 ],

 'products' => [
    'driver' => 'algolia',
    'searchables' => 'collection:products',
    'fields' => ['title', 'url', 'price' ],
```

[https://statamic.com/addons/jonassiewertsen/live-search](https://statamic.com/addons/jonassiewertsen/live-search)

