# Product recommendation based on weather forecast API

## Overview

This service is created to provide product recommendations based on weather forecast for the next 3 days. <br>
The forecasts are based on [Meteo.lt API](https://api.meteo.lt/) - the most occuring weather condition of the day is used for the recommendation. <br>
Product are stored in a MySQL database.

## Tutorial

To get the recommended products, make a GET request to this endpoint:

`GET https://weather-api-products.000webhostapp.com/api/products/recommended/:city`

Here, **city** indicates which city's weather forecast will be used for the product recommendation.

The response will include:
- source (LHMT)
- city
- recommendations for three dates:
    - weather forecast
    - date
    - products:
        -  name of the product
        -  price
        -  sku - stock-keeping unit code

## Examples

The example of the response:

```

{
  "source": "LHMT",
  "city": "kaunas",
  "recommendations": [
    {
      "weather_forecast": "clear",
      "date": "2022-05-17",
      "products": [
        {
          "sku": "CLR-001",
          "name": "Classy Sunglasses",
          "price": 12.99
        },
        {
          "sku": "CLR-002",
          "name": "Baseball Cap  Hat",
          "price": 10.59
        }
      ]
    },
    {
      "weather_forecast": "clear",
      "date": "2022-05-18",
      "products": [
        {
          "sku": "CLR-001",
          "name": "Classy Sunglasses",
          "price": 12.99
        },
        {
          "sku": "CLR-002",
          "name": "Baseball Cap  Hat",
          "price": 10.59
        }
      ]
    },
    {
      "weather_forecast": "overcast",
      "date": "2022-05-19",
      "products": [
        {
          "sku": "OVC-001",
          "name": "Colorful Umbrella",
          "price": 9.99
        },
        {
          "sku": "OVC-002",
          "name": "Trench Coat",
          "price": 39.99
        }
      ]
    }
  ]
}

```
