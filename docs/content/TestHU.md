# 🧪 LifeAchievements™ – Tesztelési jegyzőkönyv

## 📊 Áttekintés

- **Automatizált tesztek:** 37  
- **Manuális tesztek:** 10  
- **Összes teszt:** 47  
- **Utolsó sikeres futás:** 2026-04-28  
- **Általános állapot:** ✅ Sikeres

### Hogyan futtathatóak a tesztek?

Az alábbi parancsokat indítsd el a LifeAchievements mappában miután az applikáció elindult:
- docker compose exec backend fish
- php artisan test tests/ProjektTests.php 

---

## 🤖 Automatizált tesztek

### 🔹 Unit tesztek

| Test ID | Suite | Testcase | Description | Expected result | Final result | Dependencies | Runtime | Status |
|--------|------|----------|-------------|----------------|--------------|--------------|---------|--------|
| TAU1 | UserTests | UserCanRegisterSuccessfully | Tests registration with valid data | User can register | User could register | Users Table | 0,340 s | ✅ |
| TAU2 | UserTests | RegistrationFailsIfPasswordsDoNotMatch | Password mismatch validation | User cannot log in | User could not log in | Users Table | 0,070 s | ✅ |
| TAU3 | LoginTests | UserCanLogIn | Valid login | User can log in | User could log in | Users Table | 0,080 s | ✅ |
| TAU4 | LoginTests | LoginFailsWithInvalidCredentials | Invalid login | User cannot log in | User could not log in | Users Table | 0,070 s | ✅ |
| TAU5 | AchievementTests | RepeatableAchievementIncrements | Repeatable logic | Count increases | Count increased | DB | 0,070 s | ✅ |
| TAU6 | ProfileTests | UserCanUpdatePassword | Update password | Update password | Password updated | Sanctum, DB | 0,070 s | ✅ |
| TAU7 | ProfileTests | BioValidationFails | Bio validation | Validation fails | Validation failed | Sanctum, DB | 0,070 s | ✅ |

---

### 🔹 Acceptance tesztek

| Test ID | Suite | Testcase | Description | Expected result | Final result | Dependencies | Runtime | Status |
|--------|------|----------|-------------|----------------|--------------|--------------|---------|--------|
| TAA1 | AuthTests | UserCanAccessMeEndpoint | /me with valid token | Correct userdata | Actual correct userdata | Sanctum | 0,070 s | ✅ |
| TAA2 | AuthTests | MeEndpointFailsWithoutToken | Unauthorized access | Endpoint fails | Endpoint failed | Sanctum | 0,070 s | ✅ |
| TAA3 | AuthTests | UserCanLogOut | Logout | User can log out | User could log out | Sanctum | 0,070 s | ✅ |
| TAA4 | AchievementTests | GuestSeesAchievementsUncompleted | Guest achievements | All completed false | All uncompleted | DB | 0,070 s | ✅ |
| TAA5 | BadgeTests | UserCanListAllBadges | Badge list | Returns badges | Returned badges | DB | 0,070 s | ✅ |
| TAA6 | BadgeTests | UserCanViewSingleBadge | Single badge | Returns badge | Returned badge | DB | 0,070 s | ✅ |
| TAA7 | BadgeTests | UserCanListEarnedBadges | Earned badges | Returns user badges | Returned badges | Sanctum, DB | 0,080 s | ✅ |
| TAA8 | GoalTests | UserCanAddGoal | Add goal | Add goal | Goal added | Sanctum, DB | 0,070 s | ✅ |
| TAA9 | GoalTests | UserCanListGoals | List goals | List goals | Goals listed | Sanctum, DB | 0,070 s | ✅ |
| TAA10 | GoalTests | UserCanRemoveGoal | Remove goal | Remove goal | Goal removed | Sanctum, DB | 0,070 s | ✅ |
| TAA11 | FriendTests | UserCanSendFriendRequest | Send request | Send request | Sent | Sanctum, DB | 0,070 s | ✅ |
| TAA12 | FriendTests | CannotSendRequestToSelf | Self request | Self request | Error | Sanctum, DB | 0,070 s | ✅ |
| TAA13 | FriendTests | CannotSendDuplicateRequest | Duplicate request | No duplicate | Error | Sanctum, DB | 0,070 s | ✅ |
| TAA14 | FriendTests | UserCanAcceptRequest | Accept request | Accept | Accepted | Sanctum, DB | 0,070 s | ✅ |
| TAA15 | FriendTests | UserCanCancelRequests | Cancel request | Cancel | Cancelled | Sanctum, DB | 0,070 s | ✅ |
| TAA16 | FriendTests | UserCanListRequests | List requests | List requests | Listed | Sanctum, DB | 0,070 s | ✅ |
| TAA17 | FriendTests | UserCanListFriends | List friends | List friends | Listed | Sanctum, DB | 0,070 s | ✅ |
| TAA18 | FriendTests | UserCanRemoveFriend | Remove friend | Remove friend | Removed | Sanctum, DB | 0,070 s | ✅ |
| TAA19 | UserTests | UserCanViewOtherProfiles | View profile | View profile | Can view profile | Users Table | 0,070 s | ✅ |
| TAA20 | ProfileTests | UserCanUpdateName | Update name | Update name | Updated | DB | 0,070 s | ✅ |
| TAA21 | ProfileTests | UserCanUpdateBio | Update bio | Update bio | Updated | DB | 0,070 s | ✅ |

---

### 🔹 Component tesztek

| Test ID | Suite | Testcase | Description | Expected result | Final result | Dependencies | Runtime | Status |
|--------|------|----------|-------------|----------------|--------------|--------------|---------|--------|
| TAC1 | AchievementTests | AuthUserSeesCompletedAchievements | Completed flags | Correct markings | Marked correct | Sanctum, Achievements | 0,090 s | ✅ |
| TAC2 | AchievementTests | UserCanMarkAchievementAsCompleted | Mark achievement | Correct markings | Marked correct | Sanctum, DB | 0,070 s | ✅ |
| TAC3 | AchievementTests | MarkingAchievementTwiceDoesNotDuplicate | No duplicate | No duplicate records | No duplicate records | Sanctum, DB | 0,070 s | ✅ |
| TAC4 | AchievementTests | UserCanViewOwnCompletedAchievements | Fetch completed | Correct achievements | Correct achievements | Sanctum, DB | 0,070 s | ✅ |
| TAC5 | CategoryTests | ItReturnsAllCategories | Category list | Endpoint works | Endpoint works | Categories Table | 0,070 s | ✅ |
| TAC6 | CategoryTests | ItReturnsSingleCategory | Single category | Endpoint works | Endpoint works | DB | 0,070 s | ✅ |
| TAC7 | CategoryTests | ItCreatesNewCategory | Create category | Category created | Category created | Sanctum | 0,070 s | ✅ |
| TAC8 | CategoryTests | ItValidatesCategoryCreation | Validation | Return errors | Returned errors | Sanctum | 0,070 s | ✅ |
| TAC9 | BadgeTests | UserCanCreateNewBadge | Badge creation | Badge exists | Badge exists | DB | 0,070 s | ✅ |

---

## 🧍 Manuális tesztek

| Test ID | Suite | Testcase | Description | Result |
|--------|------|----------|-------------|--------|
| TMA1 | UI-Tests | RegisterPasswordTooShort | Password validation | ✅ Passed |
| TMA2 | UI-Tests | RegisterWithExistingEmail | Duplicate email | ✅ Passed |
| TMA3 | UI-Tests | LoginWrongPassword | Wrong password | ✅ Passed |
| TMA4 | Catalog | MarkCompletedVisualCheck | Completion UI | ✅ Passed |
| TMA5 | DarkThemeTests | DarkModeToggleWorks | Theme switch | ✅ Passed |
| TMA6 | Goals | SaveToGoalsButtonWorks | Add goal | ✅ Passed |
| TMA7 | Goals | RemoveFromGoalsButtonWorks | Remove goal | ✅ Passed |
| TMA8 | Friends | AddFriendFlowWorks | Friend system | ✅ Passed |
| TMA9 | Leaderboard | LeaderboardDisplaysCorrectly | Leaderboard | ✅ Passed |
| TMA10 | Profile | ProfileUpdateVisualCheck | Profile update | ✅ Passed |
