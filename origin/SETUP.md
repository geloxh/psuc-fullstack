```
psuc-forum/
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
│   │   │   ├── Controllers/
│   │   │   ├── Services/
│   │   │   ├── Repositories/
│   │   │   └── Views/
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