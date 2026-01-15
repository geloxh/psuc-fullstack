```
suc-forum/
├── src/
│   ├── Core/                          # Infrastructure & shared services
│   │   ├── Database/
│   │   │   ├── Connection.php
│   │   │   └── Repository.php
│   │   ├── Router/
│   │   │   └── Router.php
│   │   ├── Container/
│   │   │   └── ServiceContainer.php
│   │   ├── Events/
│   │   │   └── EventDispatcher.php
│   │   └── Security/
│   │       ├── Authentication.php
│   │       └── Authorization.php
│   │
│   ├── Modules/                       # Business domains
│   │   ├── Auth/
│   │   │   ├── Controllers/ LoginController.php RegisterController.php LogoutController.php
│   │   │   ├── Services/ AuthService.php UserService.php RoleService.php
│   │   │   ├── Repositories/ UserRepository.php RoleRepository.php SessionRepository.php
│   │   │   └── Views/ LoginView.php RegisterView.php LogoutView.php
│   │   ├── Forum/
│   │   │   ├── Controllers/
│   │   │   ├── Services/
│   │   │   ├── Repositories/
│   │   │   └── Views/
│   │   ├── User/
│   │   ├── Admin/
│   │   └── Messaging/
│   │
│   ├── Shared/                        # Cross-cutting concerns
│   │   ├── Services/
│   │   ├── Validators/
│   │   └── Utilities/
│   │
│   └── Web/                          # Web layer
│       ├── Controllers/
│       ├── Middleware/
│       └── Views/
│
├── public/                           # Web root
│   ├── index.php
│   ├── assets/
│   └── uploads/
│
├── config/
└── bootstrap/

```