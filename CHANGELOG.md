#### 2021-07-14

#### 2021-07-14

##### Chores

* **phpunit:**  change testsuite unitgadget/featuregadget path to gadget module (f3a4b407)
* **packages:**
  *  install meilisearch/meilisearch-php http-interop/http-factory-guzzle (7152ba8c)
  *  unistall guzzlehttp/guzzle (4ecbd7d6)
  *  install laravel scout (6e3b7547)
  *  add namesapace modules for autoload (ab4a6133)
* **test:**  add path to folders test for Equipament module (df4be57a)
* **package:**  install nwidart/laravel-modules (dea5e0fc)
*  delete laravel example  test files (0667d13b)
*  install comitizen node package (663b2d95)
*  add commitlint node package (5e21f144)
*  ignore .rnd  gerente by laravel passport on generate encryption keys (721fe752)

##### New Features

* **gadget-seeders:**  create seeder manufacturer (11367c9e)
* **modules:**
  *  create a gadget module scaffold (d5391efd)
  *  delete equipament module scaffold (2df10409)
  *  create equipament module scaffold (51c7c6f6)
* **routes:**
  *  change method name from staff logincontroller route (66012f2c)
  *  create routes for admin login and staff login (9d40f787)
* **database:**
  *  remove field status from table staff_store (36ac2231)
  *  create a migration for relationship many to many staff and store (4e8769c0)
* **controllers:**
  *  create login method for staff users (8d0b2224)
  *  create admin authenticate (59dccd53)
* **models:**
  *  add new prop status on store model (03a6ba7b)
  *  create method for get staff from the store  - reationship (7cb0c5ba)
  *  create method for get stores that staff can access - reationship (63012945)
  *  add new prop named slug to Store model and migration (5cdf6627)
  *  create mehtod for check if account can create more stores (93267c42)
  *  create get stores that account is the owner by relationship (394db65e)
  *  delete store relationship  method from User model (eba7c0ba)
  *  delete user method from Store model and create account method for relationship (b28ef70d)
  *  change Store Model prop user_id to account_id (7b96bb51)
  *  rename Staff prop user to login_name (cd04fbc0)
  *  create Staff model and migrations (73602add)
  *  create method that equipament can get your customer owner (1e0fa6b5)
  *  create method for get customers equipaments (4b44c592)
  *  create Equipament model and migration (3b0ed5b2)
  *  create a relationship method for get users from account (19dfafdd)
  *  create a relationship method where customer belongs to account (ebd74534)
  *  create Customer model (6839639c)
  *  add realtionship method to get stores where the user is the owner (61976fdf)
  *  make a method for user create store (5112887e)
  *  create a relationship oneToMany between user and store models (b2a80edc)
  *  create a store model (38de4047)
  *  create change status method for Account model (bb106eae)
  *  create a method for the relationship account belongsTo user (741a44f2)
  *  create a relationship ,hasOne, with user and account (ece7d11b)
  *  create Account model and migration (b9a1e213)
* **factory:**
  *  add new prop slug to Store factory (72fea79e)
  *  change Store Model prop user_id to account_id (21bf36d6)
  *  create a factory for Staff Model (6bee441c)
  *  create a factory for Customers (30126b5d)
  *  create a factory for Account model (a1051cea)
  *  create Store factory (83161b48)
*  add new param named slug for Account (b50a309b)
*  change the default API guard to Passport (5f473b17)
*  register Passport routes on AuthServiceProvider (b196c1a6)
*  add HasApiTokens trait in User Model from Laravel Passport (adeb1317)
* **core:**  add a Passport middleware on web middleware group for generate token for access the API (b8aa01ba)
* **package:**
  *  install laravel passport (c0f026a9)
  *  install fresh laravel 8 copy (91c38c19)

##### Bug Fixes

* **models:**
  *  move the create store methods from user to account model (5928cec2)
  *  change the condition and  on canCreateStore for check if user has or not store (8bfaa1f6)
* **factory:**  add user id param on store factory (9c349425)
* **tests:**  delete duplicate code (59488fd1)
* **test:**  remove duplicate var $data (fa6ef4cd)

##### Other Changes

* **tests:**  change test name from AccountTest (d8bdfcb3)
* **test:**  add factory for Account on create_user_app_account (f2a7b0a9)

##### Refactors

* **test:**
  *  add Account factory on all Account tests (b440014e)
  *  add factory for Account on create_user_app_account (14195626)
* **tests:**
  *  create a private method for share account fixtures data (5d3794b3)
  *  create a private method with fixture data for create user and test  models (96ba1eb5)

##### Tests

*  make test for check that should fail on create store if account is disable (029c1ef9)
*  make test for check if staff can login (675ece8c)
*  make test for check if accoun can create store if no exceeds store quantity (be010940)
*  make test for check if account fail on create store if store quantity limit exceeds (ff3e7113)
*  make test for check if account can create the first store (ebbc015c)
*  delete create store tests from UserTest (000ec9f8)
*  add factory for Store model to test can create store and remove user_id that not belongs to model (b017b60a)
*  make test for check if admin user can login (41fc2711)
*  make test for check if can create a Staff (81e87456)
*  make test for check if equipament can get your customer owner (7d22c39b)
*  make test for check if customer can get your equipaments (ef56495e)
*  make a test for check if equipament can be created (266dee01)
*  make test for check if account can get your users (f5e02a78)
*  make test for check if get account that customer belongs to (a5c86b44)
*  make test for check create Customer (d4e4935c)
*  make a test for check if the user can create more than one store (e7711ae3)
*  make a test for check if fail in create more stores if user exceed the account limit (301ff987)
*  chekc user can create the first store (c52a8188)
*  check user can create a new store (cfb55012)
*  make test for should change account status (1edf674d)
*  account creation test (8c814dc6)
*  assert in delete user model (65638988)
*  assert in create new user (f36f1776)
* **feature:**  make test for check can create a store (50c316ce)
* **models:**
  *  check the relationship if user has an Account (460ad9d3)
  *  check if account belongs to user (6899d059)
  *  create a test for assert that user app account can delete (921c2592)

