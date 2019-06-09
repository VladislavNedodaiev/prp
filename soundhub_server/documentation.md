# Api documentation

## User api
### Base url - `/api/v1/users`

1. Create User - `/` 

    Method: `POST`

    Input:
    
    ```
    {
	  "username":"onsha",
	  "password":"password123",
	  "email": "bohdan.onsha@nure.ua"
    }
    ```
    
    Output:
    ```
    {
      "balance": 0,
      "date_of_reg": "Sat, 08 Jun 2019 00:00:00 GMT",
      "email": "bohdan.onsha@nure.ua",
      "is_premium": false,
      "phone": null,
      "photo_path": null,
      "premium_exp_date": null,
      "username": "onsha"
    }
    ```
2. Get User - `/<string:username>`

    Method : `GET`
    
    Ex.: /onsha
    
    Output:
    ```
    {
      "balance": 0,
      "date_of_reg": "Sat, 08 Jun 2019 00:00:00 GMT",
      "email": "bohdan.onsha@nure.ua",
      "is_premium": false,
      "phone": null,
      "photo_path": null,
      "premium_exp_date": null,
      "username": "onsha"
    }
    ```
3.  Update user data - `/<string:username>/update`
    Method: `POST`
    
    Ex.: /onsha/update
    
    Input:
     ```
    {
      "email": "bohdan.onsha123@nure.ua",
      "phone": 380991122333,
    }
    ```
    
    Output:
    
    ```
    {
      "balance": 0,
      "date_of_reg": "Sat, 08 Jun 2019 00:00:00 GMT",
      "email": "bohdan.onsha123@nure.ua",
      "is_premium": false,
      "phone": 380991122333,
      "photo_path": null,
      "premium_exp_date": null,
      "username": "onsha"
    }
    
    ```
    
    
4. Set user profile photo - `/<string:username>/set_photo`

    Method: `POST`
    
    Ex.: /onsha/set_photo
    
    Input: 
    
    form-data
    
    ```
      photo: file.png
    ```
    
     
    Output:
    
    ```
    {
        "balance": 0,
        "date_of_reg": "Sat, 08 Jun 2019 00:00:00 GMT",
        "email": "bohdan.onsha@nure.ua",
        "is_premium": false,
        "phone": null,
        "photo_path": "../Media/Photo/onsha_profile.jpg",
        "premium_exp_date": null,
        "username": "onsha"
    }
    
    ```

5. Delete user - `/<string:username>`

   Method: `DELETE`
    
   Output:
   ```
   status code: 200
   ```
