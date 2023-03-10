# Multiplayer Chess Website

A website where you can play online chess games against other users of similar skill level.

## User Features:
- Create an account, or play as a guest
- Modify account details, delete account
- Create a game and choose the length and type (bullet, blitz, rapid, classic)
- Search for an opponent with a similar skill level (based on ELO points)
- Play chess puzzles
- Play chess 960
- Play against AI
- Add friends and chat with them in-game
- View game history

## Admin Features:
- Full control over all user and game data
- Modify user information
- Access game history
- Delete games belonging to a user

## ELO Points System:
- A rating system that reflects a player's skill level in chess
- Players gain more ELO points for winning games
- The amount of points won or lost depends on the difference in ELO points between the two players
- The larger the difference, the more points are won or lost

## Ranking System:
- Grandmaster, Master, Diamond, Platinum, Gold, Silver, Bronze rankings based on ELO points

## Technical Specifications:
- Integration with a chess engine AI (such as Stockfish)
- Use of a REST API (not decided)

## Technologies:
- Frontend: HTML 5, SASS, vanilla JavaScript or Vue.js (or React)
- Backend: Pure PHP or Laravel, MySQL
- Real-time, full-duplex communication protocol: WebSocket or Socket.io
