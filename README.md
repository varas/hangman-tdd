# Hangman

Hangman application using the API spec as outlined below:

    POST /games

Start a new game

    GET /games

Overview of all games

    GET /games/:id

JSON response that should at least include:

- `word`: representation of the word that is being guessed. Should contain dots for letters that have not been guessed yet (e.g. aw.so..)
- `tries_left`: the number of tries left to guess the word (starts at 11)
- `status`: current status of the game (busy|fail|success)

    POST /games/:id

Guessing a letter, POST body:char=a

---

- Guessing a correct letter doesn’t decrement the amount of tries left
- Only valid characters are a-z
- A list of words can be found here. At the start of the game a random word should be picked from this list. 

---

## Approach:

First, build model logic, using TDD with PhpSpec and guided by DDD, in order to have a fully decoupled domain logic.
Second, functional tests were used to describe features and the client api context, facilitating an outside-in design of the app architecture (not business logic) guided by Gherkin specs with Behat.
Integration tests will be used to tie both: domain objects interaction and app features to the domain, using PhpUnit+Mockery. 
