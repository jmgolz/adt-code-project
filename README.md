# I-View / ADT Code Challenge
This was fun! I appreciated being able to choose any tech stack.

As this is a proof of concept (being a code test), there are some items I would add, should this have been a real app.

- Flesh out UI styling to give the app more of a store feel (I'm not the best UI designer)
- Additional validation checks besides payment amount being required
- Ability to search by artist name (It's hardcoded as BTS)
- Break out some code to helper functions
- Break some items out to their own components

### App Flow
1. On page load, app calls back to the Laravel backend.
2. The API endpoint built in Laravel reaches out to the Apple Store API to grab a list of albums
3. The backend portion then returns the collection from the Apple API to the app's front end to render
4. User adds items to the "cart"
5. User can now pay for the items in their cart
6. Once the user enters the amount to pay:
    1. The app calls back to the Laravel back end for processing the change
    2. Once change (by denomination) is calculated, the data is returned for the front end to process
    3. Data is displayed on the screen
7. Enjoy your music! (It's BTS, how can you not?!)

### Design Considerations
- I chose to have the backend talk to the Apple API. This way, I would have the freedom to shape the return data if needed.
- The change returned is calculated on the backend, as the front end shouldn't be processing the data, only presenting it.
- VueJS was chosen as it works quite well with Laravel.
- Laravel was chosen as it made sense for an API.