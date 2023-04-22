<?php

namespace Database\Seeders;

use App\Models\Gametype;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $pgns = [
            '1. e4 e5 2. Nf3 Nc6 3. Bb5 a6 4. Ba4 Nf6 5. O-O Be7 6. Bxc6 dxc6 7. Re1 Nd7 8. d4 exd4 9. Qxd4 O-O 10. Bf4 Nc5 11. Qe3 Bg4 12. Nd4 Qd7 13. Nc3 Rad8 14.  Nf5 Ne6 15. Nxe7+ Qxe7 16. Bg3 Bh5 17. f3 f6 18. h3 h6 19. Kh2 Bf7 20. Rad1 b6 21. a3 a5 22. Ne2 Rxd1 23. Rxd1 Rd8 24. Rd3 c5 25. Qd2 c6 26. Rxd8+ Nxd8 27. Qf4 b5 28. Qb8 Kh7 29. Bd6 Qd7 30. Ng3 Ne6 31. f4 h5 32. c3 c4 33. h4 Qd8 34. Qb7 Be8 35. Nf5 Qd7 36. Qb8 Qd8 37. Qxd8 Nxd8 38. Nd4 Nb7 39. e5 Kg8 40. Kg3 Bd7 41. Bc7 Nc5 42. Bxa5 Kf7 43. Bb4 Nd3 44. e6+ Bxe6 45. Nxc6 Bd7 46. Nd4 Nxb2 47. Kf3 Nd3 48. g3 Nc1 49. Ke3 1/2-1/2',
            '1. d4 Nf6 2. c4 e6 3. Nf3 d5 4. h3 dxc4 5. e3 c5 6. Bxc4 a6 7. O-O Nc6 8.  Nc3 b5 9. Bd3 Bb7 10. a4 b4 11. Ne4 Na5 12. Nxf6+ gxf6 13. e4 c4 14. Bc2 Qc7 15. Bd2 Rg8 16. Rc1 O-O-O 17. Bd3 Kb8 18. Re1 f5 19. Bc2 Nc6 20. Bg5 Rxg5 21. Nxg5 Nxd4 22. Qh5 f6 23. Nf3 Nxc2 24. Rxc2 Bxe4 25. Rd2 Bd6 26.  Kh1 c3 27. bxc3 bxc3 28. Rd4 c2 29. Qh6 e5 0-1',
            '1. d4 Nf6 2. c4 e6 3. Nc3 d5 4. cxd5 exd5 5. Bg5 c6 6. e3 h6 7. Bh4 Be7 8.  Bd3 O-O 9. Qc2 Re8 10. Nge2 Nbd7 11. O-O a5 12. a3 Nh5 13. Bxe7 Qxe7 14.  Rae1 Nf8 15. Nc1 Nf6 16. f3 Ne6 17. N1e2 c5 18. Bb5 Rd8 19. dxc5 Qxc5 20.  Qd2 Bd7 21. Bxd7 Nxd7 22. Nd4 Nb6 23. Rd1 Nc4 24. Qf2 Rac8 25. Na4 Qe7 26.  Rfe1 Qf6 27. Nb5 Nc7 28. Nd4 Ne6 29. Nb5 Nc7 30. Nd4 Ne6 1/2-1/2',
            '1. c4 Nf6 2. Nc3 e5 3. Nf3 Nc6 4. e3 Bb4 5. Qc2 Bxc3 6. bxc3 d6 7. e4 O-O 8. Be2 Nh5 9. d4 Nf4 10. Bxf4 exf4 11. O-O Qf6 12. Rfe1 Re8 13. Bd3 Bg4 14.  Nd2 Na5 15. c5 dxc5 16. e5 Qh6 17. d5 Rad8 18. c4 b6 19. h3 Bh5 20. Be4 Re7 21. Qc3 Rde8 22. Bf3 Nb7 23. Re2 f6 24. e6 Nd6 25. Rae1 Nf5 26. Bxh5 Qxh5 27. Re4 Qh6 28. Qf3 Nd4 29. Rxd4 cxd4 30. Nb3 g5 31. Nxd4 Qg6 32. g4 fxg3 33. fxg3 h5 34. Nf5 Rh7 35. Qe4 Kh8 36. e7 Qf7 37. d6 cxd6 38. Nxd6 Qg8 39.  Nxe8 Qxe8 40. Qe6 Kg7 41. Rf1 Rh6 42. Rd1 f5 43. Qe5+ Kf7 44. Qxf5+ Rf6 45.  Qh7+ Ke6 46. Qg7 Rg6 47. Qf8 1-0',
            '1. e4 e5 2. Nf3 Nc6 3. Bb5 a6 4. Ba4 Nf6 5. O-O Be7 6. d3 b5 7. Bb3 d6 8.  c3 O-O 9. h3 Bb7 10. a4 Na5 11. Ba2 c5 12. Bg5 h6 13. Bxf6 Bxf6 14. axb5 axb5 15. Nbd2 Nc6 16. Bd5 Rxa1 17. Qxa1 Qd7 18. Re1 Ra8 19. Qd1 Bd8 20. Nf1 Ne7 21. Bxb7 Qxb7 22. Ne3 Bb6 23. h4 Qc6 24. h5 c4 25. d4 exd4 26. Nxd4 Qc5 27. Qg4 Qe5 28. Nf3 Qe6 29. Nf5 Nxf5 30. exf5 Qf6 31. Qe4 Rb8 32. Re2 Bc5 33. g4 Qd8 34. Qd5 Kf8 35. Kf1 Rc8 36. Re4 Rb8 37. g5 hxg5 38. Rg4 Ra8 39.  Nxg5 Ra1+ 40. Ke2 Qe7+ 41. Ne4 Qe8 42. Kf3 Qa8 43. Qxa8+ Rxa8 44. f6 g6 45.  hxg6 fxg6 46. Rxg6 Ra2 47. Kg4 Rxb2 48. Rh6 1-0',
            '1. d4 Nf6 2. Nf3 d5 3. Bf4 c5 4. e3 Nc6 5. Nbd2 cxd4 6. exd4 Bf5 7. c3 e6 8. Bb5 Bd6 9. Bxd6 Qxd6 10. O-O O-O 11. Re1 h6 12. Ne5 Ne7 13. a4 a6 14.  Bf1 Nd7 15. Nxd7 Qxd7 16. a5 Qc7 17. Qf3 Rfc8 18. Ra3 Bg6 19. Nb3 Nc6 20.  Qg3 Qe7 21. h4 Re8 22. Nc5 e5 23. Rb3 Nxa5 24. Rxe5 Qf6 25. Ra3 Nc4 26.  Bxc4 dxc4 27. h5 Bc2 28. Nxb7 Qb6 29. Nd6 Rxe5 30. Qxe5 Qxb2 31. Ra5 Kh7 32. Rc5 Qc1+ 33. Kh2 f6 34. Qg3 a5 35. Nxc4 a4 36. Ne3 Bb1 37. Rc7 Rg8 38.  Nd5 Kh8 39. Ra7 a3 40. Ne7 Rf8 41. d5 a2 42. Qc7 Kh7 43. Ng6 Rg8 44. Qf7 1-0',
            '1. e4 e6 2. d4 d5 3. Nd2 c5 4. Ngf3 cxd4 5. Nxd4 Nf6 6. exd5 Nxd5 7. N2f3 Be7 8. Bc4 Nc6 9. Nxc6 bxc6 10. O-O O-O 11. Qe2 Bb7 12. Bd3 Qc7 13. Qe4 Nf6 14. Qh4 c5 15. Bf4 Qb6 16. Ne5 Rad8 17. Rae1 g6 18. Bg5 Rd4 19. Qh3 Qc7 20.  b3 Nh5 21. f4 Bd6 22. c3 Nxf4 23. Bxf4 Rxf4 24. Rxf4 Bxe5 25. Rh4 Rd8 26.  Be4 Bxe4 27. Rhxe4 Rd5 28. Rh4 Qd6 29. Qe3 h5 30. g3 Bf6 31. Rc4 h4 32.  gxh4 Rd2 33. Re2 Rd3 34. Qxc5 Rd1+ 35. Kg2 Qd3 36. Rf2 Kg7 37. Rcf4 Qxc3 1-0',
            '1. e4 e5 2. Nf3 Nc6 3. Bb5 Nf6 4. d3 Bc5 5. c3 O-O 6. O-O d5 7. Nbd2 dxe4 8. dxe4 a5 9. a4 Qe7 10. Qc2 Nb8 11. Re1 Rd8 12. h3 h6 13. Nf1 c6 14. Bc4 Na6 15. Ng3 Qc7 16. Ba2 b5 17. Qe2 Rb8 18. Nh4 Bf8 19. Qf3 bxa4 20. Bxh6 Nc5 21. Ng6 Rxb2 22. Nxf8 Rxf8 23. Bg5 Nh7 24. Bc1 Rb5 25. Ba3 Re8 26. Bc4 Be6 27. Bxe6 Nxe6 28. Nf5 c5 29. Qe2 Rb3 30. Qc4 Qc6 31. Bc1 Nf6 32. Qxa4 Qxa4 33. Rxa4 Rxc3 34. Bb2 Rb3 35. Bxe5 Rb4 36. Rxa5 Rxe4 37. Rxe4 Nxe4 38.  Ra4 Nd4 39. Bxd4 cxd4 40. Rxd4 g6 41. Ne3 Kg7 42. Rb4 Ng3 43. Rb7 Nf5 44.  Ng4 Re7 45. Rb5 Re1+ 46. Kh2 Re2 47. Rb7 Nd6 48. Ra7 Kf8 49. Kg3 f5 50. Kf3 Re7 51. Ra8+ Re8 52. Rxe8+ Kxe8 53. Ne5 g5 54. h4 gxh4 55. Kf4 h3 56. gxh3 Ke7 57. Nc6+ Kf6 58. Nd4 *',
            '1. e4 c5 2. Nf3 e6 3. d4 cxd4 4. Nxd4 Nf6 5. Nc3 Nc6 6. Nxc6 bxc6 7. Bd3 d5 8.  O-O Rb8 9. Bg5 Rxb2 10. e5 Qa5 11. exf6 Qxc3 12. fxg7 Qxg7 13. Bf4 Rb4 14. Bg3 Bc5 15. Qe2 h5 16. Be5 f6 17. Bc3 Rg4 18. g3 Rxg3+ 19. hxg3 Qxg3+ 20. Kh1 Qh3+ 0-1',
            '1. d4 Nf6 2. c4 e6 3. Nf3 Bb4+ 4. Nbd2 d5 5. e3 O-O 6. Bd3 b6 7. O-O Bb7 8. a3 Bd6 9. b4 dxc4 10. Nxc4 Nbd7 11. Bb2 Qe7 12. Re1 c5 13. Nxd6 Qxd6 14. dxc5 Qd5 15. e4 Qh5 16. cxb6 Nxb6 17. Ne5 Qxd1 18. Raxd1 Rfd8 19. f3 Rac8 20. Bb1 Ba6 21.  Nc6 Re8 22. Nxa7 Rc7 23. Bd4 Rxa7 24. Bxb6 Rb7 25. Rd6 h6 26. a4 Nd7 27. Bf2 Bc4 28. Rc1 Bb3 29. a5 Ne5 30. Rb6 Rd7 31. Bg3 Nc4 32. Rc6 Red8 33. a6 Rd1+ 34. Rxd1 Rxd1+ 35. Kf2 Rxb1 36. a7 Rb2+ 37. Ke1 Rb1+ 38. Ke2 Rb2+ 39. Kd3 Rd2+ 40. Kc3 Rd8 41. Kxb3 Nd2+ 42. Kc2 Nc4 1-0',
            '1. d4 Nf6 2. Nc3 d5 3. f3 c5 4. e4 cxd4 5. Qxd4 Nc6 6. Bb5 e6 7. Bxc6+ bxc6 8.  e5 Nd7 9. Nh3 Qb6 10. Qxb6 axb6 11. f4 b5 12. O-O b4 13. Ne2 Bc5+ 14. Kh1 O-O 15. b3 f6 16. Bb2 fxe5 17. Ng5 Ba6 18. c4 bxc3 19. Nxc3 Bxf1 20. Rxf1 Rxf4 21.  Rxf4 exf4 22. Nxe6 Re8 23. h3 Rxe6 24. Na4 Re1+ 25. Kh2 Bg1+ 0-1',
            '1. d4 Nf6 2. Nf3 e6 3. c4 d5 4. cxd5 exd5 5. Nc3 Nc6 6. Bg5 Be6 7. e3 a6 8. a3 h6 9. Bh4 Be7 10. Bd3 O-O 11. O-O Nd7 12. Bg3 Re8 13. Rc1 Nf8 14. Qc2 Bd6 15.  Bxd6 Qxd6 16. Na4 Nd7 17. Nc5 Nxc5 18. Qxc5 Qe7 19. Qxe7 Rxe7 20. Rc3 Nb8 21. h3 c6 22. b4 Nd7 23. a4 Nb6 24. Ra1 Nc4 25. Bxc4 dxc4 26. a5 b5 27. axb6 Rb7 28.  Ne5 Rxb6 29. Nxc4 Rxb4 30. Na5 Rab8 31. Nxc6 Rb1+ 32. Rxb1 Rxb1+ 33. Kh2 Rb2 34.  Kg3 h5 35. h4 f6 36. d5 Bd7 37. e4 Re2 38. f3 g5 39. Ra3 gxh4+ 40. Kxh4 Rxg2 41.  Kxh5 Rg3 42. Ne7+ Kf7 43. Nf5 Bxf5 44. exf5 Rg5+ 45. Kh6 Rxf5 46. Rd3 Ke7 47.  Kg6 Rg5+ 48. Kh6 Kd6 49. f4 Rxd5 50. Ra3 a5 51. Kg6 f5 52. Kf6 Kc6 53. Ke6 Rc5 54. Ra1 Kb6 55. Kd6 Rb5 56. Ra2 Ka6 57. Ra3 Kb6 58. Ra1 Rb4 59. Ke5 Rb5+ 60. Kd6 Rc5 61. Ra2 Rb5 62. Ra1 Kb7 63. Ra2 Ka6 64. Ke6 Rc5 65. Kd6 Rc8 66. Ra1 Rc4 67.  Ke5 Rc5+ 68. Kd6 Rb5 69. Ra2 Rb8 70. Ke6 Rf8 71. Rd2 Kb5 72. Rd5+ Kb4 73. Ke7 1/2-1/2',
            '1. e4 e5 2. Nf3 Nc6 3. Bc4 Nf6 4. d3 Bc5 5. c3 O-O 6. O-O d5 7. exd5 Nxd5 8. Re1 Bg4 9. h3 Bh5 10. Nbd2 Nb6 11. b4 Bd6 12. a4 a5 13. b5 Ne7 14. Ne4 Ned5 15. Bxd5 Nxd5 16. Bb2 Nf4 17. d4 Re8 18. d5 h6 19. c4 f5 20. Ng3 Bxf3 21. Qxf3 e4 22. Qb3 Qg5 23. Bc1 h5 24. Bxf4 Bxf4 25. Ne2 Be5 26. Rad1 f4 27. f3 e3 28. Qc2 Rf8 29.  Nd4 Bxd4 30. Rxd4 Rae8 31. Re2 b6 32. Qd3 Rf6 33. Re4 Re5 34. Qd4 Rxe4 35. Qxe4 Qf5 36. Qxf5 Rxf5 37. Kf1 Kf7 38. Ke1 Rg5 39. Kd1 Ke7 40. Kc2 Kd6 41. Kc3 Kc5 42. Rb2 Re5 43. Re2 g5 44. Kd3 Re8 45. Kc3 g4 46. hxg4 hxg4 47. fxg4 Re4 48. g5 Rxc4+ 49. Kb3 Rd4 50. Rc2+ Kxd5 51. Rxc7 e2 52. Re7 Re4 53. Rd7+ Ke5 0-1',
            '1. e4 c6 2. d4 d5 3. e5 c5 4. c4 e6 5. Nf3 Nc6 6. Nc3 cxd4 7. Nxd4 Nxe5 8. cxd5 Nf6 9. Bb5+ Bd7 10. Qe2 Bxb5 11. Ndxb5 Bc5 12. Bf4 Ng6 13. Nc7+ Kf8 14. Bg3 Rc8 15. d6 Nd5 16. N7xd5 exd5 17. Rd1 Qe8 18. Rxd5 Qxe2+ 19. Kxe2 f6 20. d7 Rd8 21.  Rxc5 Kf7 22. Rd1 Ne5 23. Bxe5 fxe5 24. Rc7 Ke6 25. Rxb7 Rhf8 26. Ne4 h6 27. Rxa7 Rb8 28. Rd6+ Kf5 29. Ng3+ Kf4 30. Ra4+ 1-0',
            '1. e4 e6 2. Nc3 d5 3. d3 Nf6 4. Bd2 c5 5. e5 Nfd7 6. f4 Nc6 7. Nf3 a6 8. Be2 b5 9. a3 Qb6 10. O-O h6 11. Kh1 Bb7 12. Qe1 O-O-O 13. Nd1 Be7 14. c3 Rdg8 15. a4 g5 16. axb5 axb5 17. d4 g4 18. Ng1 cxd4 19. cxd4 Nxd4 20. Ba5 Qc6 21. Qd2 Nb3 22.  Qc3 Nxa1 23. Qxc6+ Bxc6 24. Ne3 Nb3 25. Be1 h5 26. Nc2 h4 27. h3 d4 28. Bxg4 Rxg4 29. hxg4 h3 30. Nf3 d3 31. Ncd4 Nxd4 0-1',
            '1. d4 d5 2. c4 e6 3. Nc3 c6 4. Nf3 Nf6 5. Bg5 Be7 6. e3 O-O 7. Qc2 h6 8. h4 Nbd7 9. O-O-O b6 10. Bxf6 Nxf6 11. Ne5 Bb7 12. g4 Bd6 13. g5 Bxe5 14. dxe5 Ng4 15.  gxh6 Nxh6 16. Ne4 dxe4 17. Rxd8 Raxd8 18. Bg2 c5 19. Bxe4 Bxe4 20. Qxe4 f5 21.  Qc6 Rfe8 22. Rd1 Rxd1+ 23. Kxd1 Kf7 24. f3 f4 25. e4 Ng8 26. Qd7+ Re7 27. Qd2 g5 28. hxg5 Kg6 29. Qd8 Kg7 30. Ke2 Rf7 31. Qc8 Re7 32. a3 Kf7 33. b4 cxb4 34. axb4 a5 35. b5 Kg7 36. Qd8 1-0',
            '1. e4 e5 2. Nf3 Nc6 3. Bb5 a6 4. Ba4 Nf6 5. d3 d6 6. c3 g6 7. O-O Bg7 8. h3 O-O 9. Nbd2 b5 10. Bc2 Re8 11. a4 Bb7 12. b4 Qe7 13. Re1 Rad8 14. Nb3 d5 15. Qe2 d4 16. Nc5 Bc8 17. axb5 axb5 18. Bd2 Nd7 19. Nxd7 Bxd7 20. Reb1 Ra8 21. Qe1 Bf8 22.  Rxa8 Rxa8 23. c4 bxc4 24. dxc4 Ra2 25. Bb3 Rxd2 26. Qxd2 Nxb4 27. c5 Qxc5 28.  Qg5 Nd3 29. Qd8 Bb5 30. Ng5 Bc4 31. Bxc4 Qxc4 32. Nxh7 Kxh7 33. Qxf8 Qa2 34. Rf1 c5 35. h4 Qc4 36. h5 gxh5 37. Qe7 Qe6 38. Qg5 Qg6 39. Qd2 Qxe4 40. Ra1 c4 41.  Ra7 Kg6 42. Ra6+ f6 43. Ra7 Qe1+ 44. Qxe1 Nxe1 45. Kf1 Nd3 46. Rc7 c3 47. Ke2 Nf4+ 48. Kf3 Kf5 49. Rc5 d3 50. g3 d2 51. Rxc3 0-1',
            '1. c4 c5 2. Nc3 Nc6 3. g3 g6 4. Bg2 Bg7 5. Nf3 d6 6. O-O Bf5 7. d3 Qd7 8. Re1 Bh3 9. Bd2 h5 10. Bxh3 Qxh3 11. Ng5 Qd7 12. h4 Nf6 13. Nd5 O-O 14. Bc3 Nxd5 15.  cxd5 Nd4 16. e3 Nf5 17. Bxg7 Kxg7 18. d4 Kg8 19. dxc5 dxc5 20. Nf3 Rad8 21. e4 Nd6 22. Qc1 Kh7 23. Ng5+ Kg8 24. Qxc5 Rc8 25. Qb4 Rc4 26. Qd2 Rfc8 27. e5 Rc2 28. Qf4 R8c4 29. Qf3 Nf5 30. Nxf7 Nxh4 31. Nh6+ Kg7 32. gxh4 Kxh6 33. e6 Qd6 34.  Re4 Rxe4 35. Qxe4 Rxb2 36. Qd4 Kh7 37. Qxb2 Qf4 38. Qb3 Qxh4 39. Qg3 Qd4 40. Rc1 Qxd5 41. Rc7 Qxe6 42. Rxb7 Qe1+ 43. Kh2 Qe4 44. Rxa7 h4 45. Qc7 Qf3 46. Qxe7+ Kh6 47. Qxh4+ Qh5 48. Qxh5+ gxh5 49. Rb7 h4 50. a4 h3 51. a5 Kg6 52. Rb5 Kh6 53.  a6 Kg6 54. a7 Kf6 55. a8=Q Kg6 56. Qa6+ Kg7 57. Rb7+ Kg8 58. Qa8# 1-0',
            '1. e4 e5 2. Bc4 Nf6 3. d4 exd4 4. Nf3 Nc6 5. O-O Nxe4 6. Re1 d5 7. Bxd5 Qxd5 8.  Nc3 Qh5 9. Nxe4 Be6 10. Bg5 Bd6 11. h4 h6 12. Bf6 O-O 13. Nxd6 cxd6 14. Bxd4 Bg4 15. Bc3 Rfe8 16. Qd3 Bxf3 17. Qxf3 Qxf3 18. gxf3 d5 19. Rad1 Rxe1+ 20. Rxe1 d4 21. Bd2 Rd8 22. Re4 f6 23. a3 Kf7 24. Kf1 Rd5 25. Ke2 f5 26. Rf4 g5 27. hxg5 hxg5 28. Re4 fxe4 29. fxe4 Re5 30. Kd3 Kg6 31. f4 gxf4 32. Bxf4 Rh5 33. b4 Rh3+ 0-1',
            '1. d4 d5 2. c4 e6 3. Nc3 Nf6 4. Bg5 Be7 5. e3 O-O 6. Nf3 h6 7. Bh4 Nbd7 8. Qc2 dxc4 9. Bxc4 Nb6 10. Bd3 Nbd5 11. a3 Nxc3 12. bxc3 b6 13. O-O Bb7 14. e4 Nh7 15.  Bg3 Ng5 16. Nd2 c5 17. h4 Nh7 18. e5 f5 19. exf6 Nxf6 20. Bc4 Bd5 21. Rfe1 cxd4 22. cxd4 Qd7 23. Qg6 Rac8 24. Bd3 Bd6 25. Be5 Qe8 26. Bxd6 Qxg6 27. Bxg6 1-0',
            '1. d4 Nf6 2. c4 e6 3. Nf3 Bb4+ 4. Bd2 c5 5. a3 Bxd2+ 6. Qxd2 cxd4 7. Nxd4 d5 8.  Nc3 Nc6 9. cxd5 Nxd5 10. Nxc6 bxc6 11. e4 Nxc3 12. Qxc3 O-O 13. Be2 Qb6 14. O-O a5 15. b4 Bb7 16. Qc5 Qxc5 17. bxc5 a4 18. Rfd1 Ra5 19. Rac1 g6 20. Rd6 Rc8 21.  f4 Ba6 22. Bxa6 Rxa6 23. Rc4 Rb8 24. Rdd4 Rb5 25. Rxa4 Rxa4 26. Rxa4 Rxc5 27.  Kf2 Rc2+ 28. Kf3 c5 29. Ra8+ Kg7 30. a4 Rc3+ 31. Kf2 Rc2+ 32. Kf3 c4 33. a5 c3 34. a6 Ra2 35. a7 c2 36. Rc8 Rxa7 37. Rxc2 Ra3+ 38. Kf2 Kf6 39. Rc5 h5 40. h4 Ra1 41. Rc7 Rh1 42. g3 Ra1 43. Kf3 Ra3+ 44. Kg2 Re3 45. e5+ Kg7 46. Kf2 Rd3 47.  Kg2 Kf8 48. Ra7 Ke8 49. Kf2 Rd7 50. Ra6 Rb7 51. Kf3 Kd7 52. Rd6+ Kc7 53. Rd3 Kc6 54. Rd8 Rd7 55. Rc8+ Kd5 56. Rc1 Rb7 57. Rd1+ Kc5 58. Rc1+ Kd4 59. Rd1+ Kc4 60.  Rd8 Kc5 61. Rc8+ Kd5 62. Rd8+ Kc6 63. Rd6+ Kc7 64. Rd3 Rb6 65. Rd4 Rc6 66. Ra4 Kd7 67. Ra7+ Rc7 68. Ra6 Ke7 69. Rd6 f6 70. Ra6 Rc3+ 71. Kf2 fxe5 72. fxe5 Rc5 73. Ra7+ Kf8 74. Kf3 Rxe5 75. Kf4 Rf5+ 76. Ke4 Rf7 77. Ra6 Ke7 78. Ra8 Rf5 79.  Ra7+ Kf6 80. Ra8 Rb5 81. Rf8+ Ke7 82. Rg8 Kf7 83. Ra8 Rb1 84. Kf4 Rf1+ 85. Ke4 Rc1 86. Ke5 Re1+ 87. Kf4 Rf1+ 88. Ke5 Rf5+ 89. Ke4 g5 90. hxg5 Rxg5 91. Rh8 Kg7 92. Re8 Rxg3 93. Rxe6 h4 94. Kf4 Rg1 95. Re3 Kg6 96. Re6+ Kh5 97. Re5+ Kh6 98.  Re6+ Kg7 99. Re3 Kg6 100. Re6+ Kg7 101. Re3 Kh6 102. Re6+ Rg6 103. Rxg6+ Kxg6 1/2-1/2',
            '1. d4 f5 2. g3 Nf6 3. Bg2 g6 4. c4 Bg7 5. Nc3 O-O 6. Nf3 d6 7. O-O c6 8. Qc2 Qe8 9. b3 e5 10. Ba3 exd4 11. Nxd4 Ne4 12. Nxe4 fxe4 13. Rad1 e3 14. f4 c5 15. Nb5 Bf5 16. Qc1 Nc6 17. Nxd6 Qe7 18. Bxc5 Qc7 19. Nb5 Qa5 20. Bxf8 Rxf8 21. a3 Qb6 22. b4 a6 23. Nc3 Nd4 24. c5 Qc7 25. Qxe3 Nc2 26. Qf3 Bd4+ 27. Rxd4 Nxd4 28.  Qd5+ Be6 29. Qxd4 Rd8 30. Nd5 Bxd5 31. Bxd5+ Rxd5 32. Qxd5+ Kg7 33. Qe5+ 1-0',
            '1. e4 d5 2. exd5 Qxd5 3. Nc3 Qa5 4. Nf3 Nf6 5. d4 c6 6. Bc4 b5 7. Bb3 e6 8. Bd2 Qc7 9. O-O Be7 10. Re1 O-O 11. Ne5 Nbd7 12. Qe2 a5 13. a4 b4 14. Ne4 h6 15.  Nxf6+ Bxf6 16. Nxd7 Bxd7 17. c3 c5 18. dxc5 Qxc5 19. Rac1 bxc3 20. Bxc3 Qg5 21.  Bd2 Qh4 22. Rc4 Bd4 23. Bc3 e5 24. Qd2 Rfe8 25. g3 Qf6 26. Bxd4 exd4 27. Rxe8+ Rxe8 28. Rxd4 Bh3 29. Rf4 Qc6 30. Bxf7+ Kh8 31. Bd5 Qxd5 0-1',
            '1. c4 e6 2. g3 d5 3. Bg2 Nf6 4. Nf3 c5 5. O-O Nc6 6. d4 Be7 7. cxd5 Nxd5 8. Nc3 Nxc3 9. bxc3 O-O 10. h4 cxd4 11. cxd4 Bf6 12. Be3 Ne7 13. Bg5 Nd5 14. e4 Bxg5 15. hxg5 Ne7 16. Qd2 b6 17. Rac1 Bb7 18. Ne5 Qd6 19. f4 Rac8 20. Nc4 Qd7 21. Ne3 Rfd8 22. Rxc8 Rxc8 23. Rd1 Qc7 24. Kf2 Qc3 25. Qxc3 Rxc3 26. d5 exd5 27. exd5 g6 28. d6 Nc6 29. Bxc6 Bxc6 30. d7 Bxd7 31. Rxd7 Ra3 32. Ng4 Rxa2+ 33. Kf3 Ra3+ 34.  Ke4 Rxg3 35. Nh6+ Kf8 36. Rxf7+ Ke8 37. Rxa7 Rg1 38. Rxh7 Re1+ 39. Kd4 Rf1 40.  Ke5 Re1+ 41. Kf6 Rf1 42. f5 gxf5 43. Nxf5 b5 44. g6 b4 45. g7 Rg1 46. Rh8+ 1-0',
            '1. e4 c6 2. d4 d5 3. e5 Bf5 4. Bd3 Bxd3 5. Qxd3 e6 6. Nf3 Qb6 7. c3 Qa6 8. Qxa6 Nxa6 9. O-O Ne7 10. Nbd2 c5 11. Re1 Nc6 12. a3 c4 13. Nf1 h6 14. Bf4 Be7 15. Ne3 b5 16. Nd2 O-O 17. h3 Nc7 18. Kh2 a5 19. Rg1 b4 20. a4 Rab8 21. Rab1 Rb7 22. f3 Rfb8 23. g4 bxc3 24. bxc3 Rb2 25. Ng2 Rxb1 26. Rxb1 Rxb1 27. Nxb1 Na8 28. Kg3 Nb6 29. Bc1 Nxa4 30. Ne3 Na7 31. f4 Nb5 32. Nd1 Nb6 33. Ne3 Nd7 34. Nc2 Nb8 35.  Kf3 Nc6 36. Bb2 Kf8 37. Kg3 Ke8 38. Kf3 Kd7 39. Kg3 a4 40. Kf3 Kc7 41. Kg3 Kb6 42. Kf3 Ka5 43. Ke3 g6 44. Kf3 a3 45. Ncxa3 Nxa3 46. Nxa3 Ka4 47. Nb1 Kb3 48.  Bc1 Kc2 49. Ba3 Kxb1 50. Bxe7 Nxe7 51. Ke3 Kc2 52. f5 Kxc3 53. f6 Nc6 54. g5 h5 55. h4 Nxd4 56. Kf4 Kd3 57. Kg3 c3 58. Kf2 c2 59. Kg3 c1=Q 60. Kf2 Qf4+ 61. Kg2 Qf3+ 62. Kh2 Qg4 63. Kh1 Ke2 64. Kh2 Nf3+ 65. Kh1 Qg1# 0-1',
            '1. e4 c5 2. c3 Nf6 3. e5 Nd5 4. d4 cxd4 5. Nf3 Nc6 6. Bc4 Nb6 7. Bb3 g6 8. cxd4 Bg7 9. Nc3 d6 10. Bf4 dxe5 11. dxe5 O-O 12. h3 a5 13. a3 Kh8 14. O-O Nd7 15. Re1 Nc5 16. Bc4 Be6 17. Bxe6 Nxe6 18. Bg3 Qb6 19. Rb1 Rad8 20. Qa4 Ncd4 21. Nxd4 Rxd4 22. Qb5 Qxb5 23. Nxb5 Rd2 24. b4 axb4 25. axb4 Nd4 26. Nxd4 Rxd4 27. Rec1 Rd7 28. b5 Bh6 29. Rc4 b6 30. Rc6 Rb7 31. e6 fxe6 32. Rxe6 Kg8 33. Rc6 Bd2 34.  Be5 Ba5 35. Rd1 Bb4 36. f3 Bc5+ 37. Kf1 Kf7 38. Ke2 Ra8 39. Rd2 Rba7 40. Bd4 Bxd4 41. Rxd4 Rb8 42. g4 Ra2+ 43. Rd2 Ra5 44. Rb2 Ra4 45. h4 Rb7 46. Ke3 Ra3+ 47. Ke4 Ra4+ 48. Ke3 Ra3+ 49. Ke2 Ra4 50. Rb3 Ra2+ 51. Ke3 Ra4 52. h5 gxh5 53.  gxh5 Rh4 54. h6 Rh5 55. Kf4 e6 56. Rd3 Rxb5 57. Rdd6 Rf5+ 58. Kg4 Rf6 59. Rxb6 1/2-1/2',
            '1. d4 Nf6 2. Nf3 d6 3. Nc3 Bf5 4. Bf4 Nbd7 5. e3 Nh5 6. Nh4 Bg6 7. Bg5 f6 8. g4 Bf7 9. gxh5 fxg5 10. Nf5 g6 11. Ng3 Nf6 12. Nce4 Nxe4 13. Nxe4 e6 14. Be2 d5 15.  Ng3 Qd6 16. c3 Bg7 17. e4 dxe4 18. Nxe4 Qf4 19. Nc5 O-O 20. O-O Rad8 21. Nd3 Qh4 22. f4 gxh5 23. fxg5 Bg6 24. Qd2 Rd5 25. Rxf8+ Bxf8 26. Rf1 Bd6 27. Bf3 Qxg5+ 28. Qxg5 Rxg5+ 29. Kh1 Bxd3 0-1',
        ];

        User::factory()->makeAdmin()->create([
            'first_name' => 'El Mehdi',
            'last_name' => 'Qaos',
            'user_name' => 'MehdiQaos',
            'email' => 'mehdi.qaos@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->makeAdmin()->create([
            'first_name' => 'Mohammed',
            'last_name' => 'Qaos',
            'user_name' => 'MohammedQaos',
            'email' => 'mohammed.qaos@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $gameTypesIds = Gametype::pluck('id')->toArray();

        $users = User::factory()->makePleb()->count(20)->create();
        $users->each(function($user) use($gameTypesIds) {
            foreach($gameTypesIds as $id) {
                Rating::create([
                    'user_id' => $user->id,
                    'rating' => random_int(400, 1500),
                    'gametype_id' => $id,
                ]);
            }
        });
    }
}
