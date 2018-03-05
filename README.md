
## Installation

```sh
git clone git@github.com:ElijahKaftanov/user-filter.git
cd user-filter
docker-compose build
docker-compose up
docker exec -it test-filter-app sh
bin/console doctrine:migrations:migrate
```

## Input Format
Yaml examples are stored in the 'input' directory
#### Array format:
```php
[
    'or', 
    ['=', 'country', 'Ukraine'],
    [
        'and',
        ['=', 'name', 'Elijah'],
        ['!=', 'state', 0] // not active
    ]
]
```
