<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Gamerule;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pgns = [
            '1. d4 Nf6 2. c4 e6 3. Nf3 d5 4. h3 dxc4 5. e3 c5 6. Bxc4 a6 7. O-O Nc6 8.  Nc3 b5 9. Bd3 Bb7 10. a4 b4 11. Ne4 Na5 12. Nxf6+ gxf6 13. e4 c4 14. Bc2 Qc7 15. Bd2 Rg8 16. Rc1 O-O-O 17. Bd3 Kb8 18. Re1 f5 19. Bc2 Nc6 20. Bg5 Rxg5 21. Nxg5 Nxd4 22. Qh5 f6 23. Nf3 Nxc2 24. Rxc2 Bxe4 25. Rd2 Bd6 26.  Kh1 c3 27. bxc3 bxc3 28. Rd4 c2 29. Qh6 e5 0-1',
            '1. d4 Nf6 2. c4 e6 3. Nc3 d5 4. cxd5 exd5 5. Bg5 c6 6. e3 h6 7. Bh4 Be7 8.  Bd3 O-O 9. Qc2 Re8 10. Nge2 Nbd7 11. O-O a5 12. a3 Nh5 13. Bxe7 Qxe7 14.  Rae1 Nf8 15. Nc1 Nf6 16. f3 Ne6 17. N1e2 c5 18. Bb5 Rd8 19. dxc5 Qxc5 20.  Qd2 Bd7 21. Bxd7 Nxd7 22. Nd4 Nb6 23. Rd1 Nc4 24. Qf2 Rac8 25. Na4 Qe7 26.  Rfe1 Qf6 27. Nb5 Nc7 28. Nd4 Ne6 29. Nb5 Nc7 30. Nd4 Ne6 1/2-1/2',
            '1. e4 e6 2. d4 d5 3. Nd2 c5 4. Ngf3 cxd4 5. Nxd4 Nf6 6. exd5 Nxd5 7. N2f3 Be7 8. Bc4 Nc6 9. Nxc6 bxc6 10. O-O O-O 11. Qe2 Bb7 12. Bd3 Qc7 13. Qe4 Nf6 14. Qh4 c5 15. Bf4 Qb6 16. Ne5 Rad8 17. Rae1 g6 18. Bg5 Rd4 19. Qh3 Qc7 20.  b3 Nh5 21. f4 Bd6 22. c3 Nxf4 23. Bxf4 Rxf4 24. Rxf4 Bxe5 25. Rh4 Rd8 26.  Be4 Bxe4 27. Rhxe4 Rd5 28. Rh4 Qd6 29. Qe3 h5 30. g3 Bf6 31. Rc4 h4 32.  gxh4 Rd2 33. Re2 Rd3 34. Qxc5 Rd1+ 35. Kg2 Qd3 36. Rf2 Kg7 37. Rcf4 Qxc3 1-0',
            '1. e4 c5 2. Nf3 e6 3. d4 cxd4 4. Nxd4 Nf6 5. Nc3 Nc6 6. Nxc6 bxc6 7. Bd3 d5 8.  O-O Rb8 9. Bg5 Rxb2 10. e5 Qa5 11. exf6 Qxc3 12. fxg7 Qxg7 13. Bf4 Rb4 14. Bg3 Bc5 15. Qe2 h5 16. Be5 f6 17. Bc3 Rg4 18. g3 Rxg3+ 19. hxg3 Qxg3+ 20. Kh1 Qh3+ 0-1',
            '1. d4 Nf6 2. Nc3 d5 3. f3 c5 4. e4 cxd4 5. Qxd4 Nc6 6. Bb5 e6 7. Bxc6+ bxc6 8.  e5 Nd7 9. Nh3 Qb6 10. Qxb6 axb6 11. f4 b5 12. O-O b4 13. Ne2 Bc5+ 14. Kh1 O-O 15. b3 f6 16. Bb2 fxe5 17. Ng5 Ba6 18. c4 bxc3 19. Nxc3 Bxf1 20. Rxf1 Rxf4 21.  Rxf4 exf4 22. Nxe6 Re8 23. h3 Rxe6 24. Na4 Re1+ 25. Kh2 Bg1+ 0-1',
            '1. e4 c6 2. d4 d5 3. e5 c5 4. c4 e6 5. Nf3 Nc6 6. Nc3 cxd4 7. Nxd4 Nxe5 8. cxd5 Nf6 9. Bb5+ Bd7 10. Qe2 Bxb5 11. Ndxb5 Bc5 12. Bf4 Ng6 13. Nc7+ Kf8 14. Bg3 Rc8 15. d6 Nd5 16. N7xd5 exd5 17. Rd1 Qe8 18. Rxd5 Qxe2+ 19. Kxe2 f6 20. d7 Rd8 21.  Rxc5 Kf7 22. Rd1 Ne5 23. Bxe5 fxe5 24. Rc7 Ke6 25. Rxb7 Rhf8 26. Ne4 h6 27. Rxa7 Rb8 28. Rd6+ Kf5 29. Ng3+ Kf4 30. Ra4+ 1-0',
            '1. e4 e6 2. Nc3 d5 3. d3 Nf6 4. Bd2 c5 5. e5 Nfd7 6. f4 Nc6 7. Nf3 a6 8. Be2 b5 9. a3 Qb6 10. O-O h6 11. Kh1 Bb7 12. Qe1 O-O-O 13. Nd1 Be7 14. c3 Rdg8 15. a4 g5 16. axb5 axb5 17. d4 g4 18. Ng1 cxd4 19. cxd4 Nxd4 20. Ba5 Qc6 21. Qd2 Nb3 22.  Qc3 Nxa1 23. Qxc6+ Bxc6 24. Ne3 Nb3 25. Be1 h5 26. Nc2 h4 27. h3 d4 28. Bxg4 Rxg4 29. hxg4 h3 30. Nf3 d3 31. Ncd4 Nxd4 0-1',
            '1. d4 d5 2. c4 e6 3. Nc3 c6 4. Nf3 Nf6 5. Bg5 Be7 6. e3 O-O 7. Qc2 h6 8. h4 Nbd7 9. O-O-O b6 10. Bxf6 Nxf6 11. Ne5 Bb7 12. g4 Bd6 13. g5 Bxe5 14. dxe5 Ng4 15.  gxh6 Nxh6 16. Ne4 dxe4 17. Rxd8 Raxd8 18. Bg2 c5 19. Bxe4 Bxe4 20. Qxe4 f5 21.  Qc6 Rfe8 22. Rd1 Rxd1+ 23. Kxd1 Kf7 24. f3 f4 25. e4 Ng8 26. Qd7+ Re7 27. Qd2 g5 28. hxg5 Kg6 29. Qd8 Kg7 30. Ke2 Rf7 31. Qc8 Re7 32. a3 Kf7 33. b4 cxb4 34. axb4 a5 35. b5 Kg7 36. Qd8 1-0',
            '1. e4 e5 2. Bc4 Nf6 3. d4 exd4 4. Nf3 Nc6 5. O-O Nxe4 6. Re1 d5 7. Bxd5 Qxd5 8.  Nc3 Qh5 9. Nxe4 Be6 10. Bg5 Bd6 11. h4 h6 12. Bf6 O-O 13. Nxd6 cxd6 14. Bxd4 Bg4 15. Bc3 Rfe8 16. Qd3 Bxf3 17. Qxf3 Qxf3 18. gxf3 d5 19. Rad1 Rxe1+ 20. Rxe1 d4 21. Bd2 Rd8 22. Re4 f6 23. a3 Kf7 24. Kf1 Rd5 25. Ke2 f5 26. Rf4 g5 27. hxg5 hxg5 28. Re4 fxe4 29. fxe4 Re5 30. Kd3 Kg6 31. f4 gxf4 32. Bxf4 Rh5 33. b4 Rh3+ 0-1',
            '1. d4 d5 2. c4 e6 3. Nc3 Nf6 4. Bg5 Be7 5. e3 O-O 6. Nf3 h6 7. Bh4 Nbd7 8. Qc2 dxc4 9. Bxc4 Nb6 10. Bd3 Nbd5 11. a3 Nxc3 12. bxc3 b6 13. O-O Bb7 14. e4 Nh7 15.  Bg3 Ng5 16. Nd2 c5 17. h4 Nh7 18. e5 f5 19. exf6 Nxf6 20. Bc4 Bd5 21. Rfe1 cxd4 22. cxd4 Qd7 23. Qg6 Rac8 24. Bd3 Bd6 25. Be5 Qe8 26. Bxd6 Qxg6 27. Bxg6 1-0',
            '1. d4 f5 2. g3 Nf6 3. Bg2 g6 4. c4 Bg7 5. Nc3 O-O 6. Nf3 d6 7. O-O c6 8. Qc2 Qe8 9. b3 e5 10. Ba3 exd4 11. Nxd4 Ne4 12. Nxe4 fxe4 13. Rad1 e3 14. f4 c5 15. Nb5 Bf5 16. Qc1 Nc6 17. Nxd6 Qe7 18. Bxc5 Qc7 19. Nb5 Qa5 20. Bxf8 Rxf8 21. a3 Qb6 22. b4 a6 23. Nc3 Nd4 24. c5 Qc7 25. Qxe3 Nc2 26. Qf3 Bd4+ 27. Rxd4 Nxd4 28.  Qd5+ Be6 29. Qxd4 Rd8 30. Nd5 Bxd5 31. Bxd5+ Rxd5 32. Qxd5+ Kg7 33. Qe5+ 1-0',
            '1. e4 d5 2. exd5 Qxd5 3. Nc3 Qa5 4. Nf3 Nf6 5. d4 c6 6. Bc4 b5 7. Bb3 e6 8. Bd2 Qc7 9. O-O Be7 10. Re1 O-O 11. Ne5 Nbd7 12. Qe2 a5 13. a4 b4 14. Ne4 h6 15.  Nxf6+ Bxf6 16. Nxd7 Bxd7 17. c3 c5 18. dxc5 Qxc5 19. Rac1 bxc3 20. Bxc3 Qg5 21.  Bd2 Qh4 22. Rc4 Bd4 23. Bc3 e5 24. Qd2 Rfe8 25. g3 Qf6 26. Bxd4 exd4 27. Rxe8+ Rxe8 28. Rxd4 Bh3 29. Rf4 Qc6 30. Bxf7+ Kh8 31. Bd5 Qxd5 0-1',
            '1. d4 Nf6 2. Nf3 d6 3. Nc3 Bf5 4. Bf4 Nbd7 5. e3 Nh5 6. Nh4 Bg6 7. Bg5 f6 8. g4 Bf7 9. gxh5 fxg5 10. Nf5 g6 11. Ng3 Nf6 12. Nce4 Nxe4 13. Nxe4 e6 14. Be2 d5 15.  Ng3 Qd6 16. c3 Bg7 17. e4 dxe4 18. Nxe4 Qf4 19. Nc5 O-O 20. O-O Rad8 21. Nd3 Qh4 22. f4 gxh5 23. fxg5 Bg6 24. Qd2 Rd5 25. Rxf8+ Bxf8 26. Rf1 Bd6 27. Bf3 Qxg5+ 28. Qxg5 Rxg5+ 29. Kh1 Bxd3 0-1',
        ];

        $usersIds = User::pluck('id')->toArray();
        $gameRulesIds = Gamerule::pluck('id')->toArray();
        $results = ['1-0', '0-1', '1/2-1/2'];
        Game::factory()->count(60)->create()->each(function($game) use($usersIds, $results, $gameRulesIds, $pgns) {
            $random2playersIds = array_rand($usersIds, 2);
            $game->white_player_id = $usersIds[$random2playersIds[0]];
            $game->black_player_id = $usersIds[$random2playersIds[1]];
            $game->gamerule_id = $gameRulesIds[array_rand($gameRulesIds)];
            $pgn = $pgns[array_rand($pgns)];
            $game->pgn = $pgn;
            if ($pgn[-1] === '0') $r = '1-0';
            else if ($pgn[-1] === '1') $r = '0-1';
            else if ($pgn[-1] === '2') $r = '1/2-1/2';
            else if ($pgn[-1] === '*') $r = '1/2-1/2';
            $game->result = $r;
            $game->date = now();
            $game->save();
        }); 
    }
}
