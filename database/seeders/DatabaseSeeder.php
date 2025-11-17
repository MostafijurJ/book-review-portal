<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\Review;
use App\Models\Bookshelf;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Create admin user (if doesn't exist)
        $admin = User::firstOrCreate(
            ['email' => 'admin@bookreview.com'],
            [
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'bio' => 'Site Administrator',
            ]
        );

        // Create a test member (if doesn't exist)
        $member = User::firstOrCreate(
            ['email' => 'booklover@example.com'],
            [
                'username' => 'booklover',
                'password' => Hash::make('password'),
                'role' => 'member',
                'bio' => 'Passionate reader and book reviewer',
            ]
        );

        // Create sample books
        $books = [
            [
                'title' => 'Dune',
                'author' => 'Frank Herbert',
                'synopsis' => 'Set on the desert planet Arrakis, Dune is the story of the boy Paul Atreides, heir to a noble family tasked with ruling an inhospitable world where the only thing of value is the "spice" melange, a drug capable of extending life and enhancing consciousness.',
                'genre' => 'Science Fiction',
                'publication_date' => '1965-08-01',
                'publisher' => 'Chilton Books',
                'page_count' => 688,
            ],
            [
                'title' => 'The Martian',
                'author' => 'Andy Weir',
                'synopsis' => 'A mission to Mars goes wrong, and astronaut Mark Watney is left behind, presumed dead. He must use his ingenuity to survive on the hostile planet.',
                'genre' => 'Science Fiction',
                'publication_date' => '2011-09-28',
                'publisher' => 'Crown Publishing Group',
                'page_count' => 369,
            ],
            [
                'title' => 'Project Hail Mary',
                'author' => 'Andy Weir',
                'synopsis' => 'Ryland Grace is the sole survivor on a desperate, last-chance mission—and if he fails, humanity and the earth itself will perish.',
                'genre' => 'Science Fiction',
                'publication_date' => '2021-05-04',
                'publisher' => 'Ballantine Books',
                'page_count' => 496,
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'synopsis' => 'A dystopian social science fiction novel about totalitarian control and surveillance.',
                'genre' => 'Dystopian Fiction',
                'publication_date' => '1949-06-08',
                'publisher' => 'Secker & Warburg',
                'page_count' => 328,
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'synopsis' => 'The story of a young girl and her family in the American South during the 1930s, dealing with racial injustice.',
                'genre' => 'Fiction',
                'publication_date' => '1960-07-11',
                'publisher' => 'J. B. Lippincott & Co.',
                'page_count' => 281,
            ],
        ];

        foreach ($books as $bookData) {
            $book = Book::firstOrCreate(
                ['title' => $bookData['title'], 'author' => $bookData['author']],
                $bookData
            );
            
            // Add some reviews (if they don't exist)
            if ($book->title === 'Dune') {
                Review::firstOrCreate(
                    [
                        'user_id' => $member->id,
                        'book_id' => $book->id,
                    ],
                    [
                        'rating' => 5,
                        'review_text' => 'An absolute masterpiece of science fiction. The world-building is incredible, and the political intrigue keeps you engaged throughout. A must-read for any sci-fi fan!',
                        'is_approved' => true,
                    ]
                );

                Bookshelf::firstOrCreate(
                    [
                        'user_id' => $member->id,
                        'book_id' => $book->id,
                    ],
                    [
                        'status' => 'read',
                    ]
                );
            }

            if ($book->title === 'The Martian') {
                Review::firstOrCreate(
                    [
                        'user_id' => $member->id,
                        'book_id' => $book->id,
                    ],
                    [
                        'rating' => 5,
                        'review_text' => 'Hilarious and scientifically accurate. Mark Watney is one of the most likable protagonists I\'ve ever read. Could not put this down!',
                        'is_approved' => true,
                    ]
                );

                Bookshelf::firstOrCreate(
                    [
                        'user_id' => $member->id,
                        'book_id' => $book->id,
                    ],
                    [
                        'status' => 'read',
                    ]
                );
            }

            // Update book ratings
            $book->updateRatingStats();
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin credentials: admin@bookreview.com / password');
        $this->command->info('Member credentials: booklover@example.com / password');
    }
}

