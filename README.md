# Join Adeo Web

## Description
Create a service, which returns product recommendations depending on the weather forecast.

## Technology stack
You are expected to use the following:

 - PHP 7, 8+ version;
 - MySQL or equivalent database engine;
 - Symfony/Laravel framework;
 
### Example
Let's say you have in stock a sunglasses, coat and an umbrella. 
If the sun is shining - you should recommend sunglasses, in case of the rain - umbrella and coat, and in case of the snow - coat would be your recommendation.

For the next 3 days depending on the forecast, select 2 items that would match the weather forecast.

You can use the following example as a starting point for your application

```http request
GET /api/products/recommended/:city
```

Input parameters `:city` - (i.e. Vilnius)

Output:
```json
{
  "city": "Vilnius",
  "recommendations": 
  [
    {
        "weather_forecast": "rain",
        "date": "2020-02-14",
        "products": [    
          {
            "sku": "UM-1",
            "name": "Black Umbrella",
            "price": 10.11
          },
          {
            "sku": "HAT-15",
            "name": "Pink Hat",
            "price": 6.07
          }
        ]
      },
      {
        "weather_forecast": "sunny",
        "date": "2020-02-15",
        "products": [
          {
            "name": "Synergistic Leather Hat",
            "sku": "UM-13",
            "price": "94.68"
          },
          {
            "name": "Heavy Duty Iron Hat",
            "sku": "UM-18",
            "price": "10.76"
          }
        ]
      },
      ...
  ]
}
```

### Requirements
 - Use **GIT** properly - just like you will do in production;
 - Store your product data in the database;
 - Service should be realized using REST API principles. Request and response should be handled in JSON format;
 - Integrate third-party API to get the current weather information in any Lithuania city. We recommend using the LHMT API: https://api.meteo.lt/ .  (Note, that this API requires you to inform the user about the source of the data, which is LHMT).
 - Use cache for all requests (for 5 min.).
 
### Suggestions
 - It should use the most occurring weather type;
 - Host it somewhere (e.g. Heroku, Google) or provide us with the ability to launch your app (include the command that would start it, bonus if you include docker-compose.yml);
 - Fill the README.md file as you would do for a production application. Include challenge description, used technologies, setup guide and usage examples.

## How we review
The submitted code will be evaluated for the following aspects:

 - **Presentation.**  Is GIT used properly? Do you make separate commits for different features? Is the README file present and well-formatted? Does README include setup instructions? Is the application hosted somewhere?
 - **Requirements.** Does it take the current weather from the API? How is the sample data generated? Does code follow REST principles? Is the database structured correctly?
 - **Architecture.** How well the components of the application are separated? Does object-oriented code follow principles such as the single responsibility principle?
 - **Correctness.** Does service do what is asked? Are data validated? Are results limited? How errors are handled? Does it return appropriate status codes?
 - **Code style.** Is the coding style consistent with the language's guidelines? Does it follow PSR-12 standard? Is it consistent throughout the codebase?
 - **Code quality.** Is the code simple, easy to understand, and maintainable? Are there any code smells or other red flags? Any automated tests (unit, integration) written?
 - **Security.** Are there any obvious vulnerabilities?

## Code submission
Create a branch and make your changes, then when you are ready just commit, submit a pull-request and mark **@joinAdeoWeb** as a reviewer.

## FAQ
In what framework do I do this task?
 - Do it with whatever framework you know best
 - All the frameworks are fine as long as they are open source
 
How much time do I have?
 - We don’t have any requirements for a time frame, but you can inform us how many hours you estimate.
 - Other developers take from ~3h till 3d to complete this task, depending on seniority level, whether they work or not and etc.

What do you want to understand from this task?
 - We try to figure out how you think, where it is easy, and you do have experience
 - We attempt to understand how you write this task - do you start from the README? Or do you dig into the code?

Do we you your code for our clients?
 - No. 99% of our clients are big eCommerce or multichannel trading businesses (Topo Centras, Jysk, Pegasas, Eoltas and etc.) - to whom this task is not applied 
