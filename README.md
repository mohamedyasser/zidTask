## Backend Assignment

## Task
You were given a sample [Laravel][laravel] project which implements sort of a personal wishlist
where user can add their wanted products with some basic information (price, link etc.) and
view the list.

#### Refactoring
The `ItemController` is messy. Please use your best judgement to improve the code. Your task
is to identify the imperfect areas and improve them whilst keeping the backwards compatibility.

#### New feature
Please modify the project to add statistics for the wishlist items. Statistics should include:

- total items count
- average price of an item
- the website with the highest total price of its items
- total price of items added this month

The statistics should be exposed using an API endpoint. **Moreover**, user should be able to
display the statistics using a CLI command.

Please also include a way for the command to display a single information from the statistics,
for example just the average price. You can add a command parameter/option to specify which
statistic should be displayed.

## Open questions
Please write your answers to following questions.

> **Please briefly explain your implementation of the new feature**   
>- use model static function to get the statistics to avoid duplicate code
>- for the CLI command, I use the `--type` option to specify which statistic to display `--type=total` or `--type=average` or `--type=highest` or `--type=monthly` or `--type=all` default is all.
>- total items count: `Item::count()`
>- average price of an item: `Item::avg('price')`
>- the website with the highest total price of its items: `Item::groupBy('provider')->selectRaw('sum(price) as total, provider')->orderBy('total', 'desc')->first()`
>- total price of items added this month: `Item::whereMonth('created_at', Carbon::now()->month)->sum('price')`

> **For the refactoring, would you change something else if you had more time?**  
>- use model binding to get the item object from the route
>- use request validation to validate the request data and use the validated data instead of the request data to avoid any security issues
>- use laravel resource to return the response in a standard format instead of serializing the data manually
>- add provider to item model to avoid database queries issues and performance issues
>- for the statistics, I would use a service class to handle the logic and use a repository to handle the database queries, but I didn't have enough time to implement it
>- for api response, I changed the response format to be more standard and to be more readable data instead of items, data instead of item

## Running the project
This project requires a database to run. For the server part, you can use `php artisan serve`
or whatever you're most comfortable with.

You can use the attached DB seeder to get data to work with.

#### Running tests
The attached test suite can be run using `php artisan test` command.

[laravel]: https://laravel.com/docs/8.x
