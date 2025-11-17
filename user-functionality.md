# User Flow Document — Book Review Portal

> Step-by-step user journeys for key tasks within the Book Review Portal, based on the functional requirements.

---

## Table of Contents

1. [User Roles](#user-roles)  
2. [Core User Flows](#core-user-flows)  
   - [Flow 1: New User Registration & First Review](#flow-1-new-user-registration--first-review)  
   - [Flow 2: Guest Browsing & Reading Reviews](#flow-2-guest-browsing--reading-reviews)  
   - [Flow 3: Member Adding a Book to a Bookshelf](#flow-3-member-adding-a-book-to-a-bookshelf)  
   - [Flow 4: Admin Content Moderation](#flow-4-admin-content-moderation)

---

## User Roles

- **Guest**: Unregistered user.  
- **Member**: Logged-in user.  
- **Admin**: Site administrator.

---

## Core User Flows

### Flow 1: New User Registration \& First Review

This flow describes the "happy path" for a new user joining the site and immediately engaging.

1. Guest lands on the Homepage.  
2. Guest clicks the `Sign Up` button in the navigation bar.  
3. Guest is taken to the Registration Page.  
4. Guest fills in the registration form (Email, Username, Password, Confirm Password).  
5. Guest clicks the `Create Account` button.  
6. The system creates the account, logs the user in, and redirects to the Homepage (now a Member).  
7. Member uses the search bar to find a book (e.g., `Dune`).  
8. Member selects the book from search results and lands on the Book Page.  
9. Member finds the `Write Your Review` section, selects a star rating (1–5), writes the review, and clicks `Submit Review`.  
10. The page updates and the review appears at the top of the book's review list.

---

### Flow 2: Guest Browsing \& Reading Reviews

This flow describes the experience for a casual, non-logged-in visitor.

1. Guest lands on the Homepage.  
2. Guest clicks a genre in the `Browse by Genre` section (e.g., `Science Fiction`).  
3. Guest is taken to the Genre Page showing a grid of books.  
4. Guest selects a book (e.g., `The Martian`) and opens its Book Page.  
5. Guest reads the synopsis and average rating, then scrolls to the `Reviews` section.  
6. Guest reads several member reviews.  
7. Guest clicks a reviewer's username (e.g., `BookLover123`) and is taken to that user's Public Profile Page.  
8. Guest views the user's bio, public bookshelves, and past reviews.

---

### Flow 3: Member Adding a Book to a Bookshelf

This flow describes how a logged-in member tracks reading progress.

1. Member searches for a book (e.g., `Project Hail Mary`) and opens its Book Page.  
2. Under the book cover, Member clicks the `Add to Shelf` button (or dropdown).  
3. Options appear: `Want to Read`, `Currently Reading`, `Read`.  
4. Member selects `Want to Read`.  
5. The UI confirms the book is on the `Want to Read` shelf.  
6. Member navigates to `My Bookshelves` via their profile.  
7. Member sees `Project Hail Mary` listed under `Want to Read`.

---

### Flow 4: Admin Content Moderation

This flow describes how an administrator handles reported or inappropriate content.

1. A Member (`JaneDoe`) finds a spammy review and clicks the `Report` button.  
2. A modal prompts for a reason; Member selects `Spam` and submits.  
3. An Admin logs in and opens the `Admin Dashboard`.  
4. Admin opens the `Reported Content` queue and sees the new report.  
5. Admin reviews the reported review and chooses either `Delete Review` or `Dismiss Report`.  
6. Admin verifies it is spam and clicks `Delete Review`.  
7. The review is removed and the report state changes to `Resolved`.

---