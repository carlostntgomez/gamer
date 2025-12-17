{ pkgs }: {
  channel = "stable-24.05";

  packages = [
    pkgs.php83
    pkgs.php83Packages.composer
    pkgs.git
  ];

  idx.extensions = [
    "onecentlin.laravel-blade"
    "xdebug.php-debug"
    "bmewburn.vscode-intelephense-client"
  ];

  idx.previews = {
    previews = {
      laravel = {
        command = [
          "php"
          "artisan"
          "serve"
          "--host=0.0.0.0"
          "--port"
          "$PORT"
        ];
        manager = "web";
      };
    };
  };

  idx.workspace.onCreate = {
    install = ''
      composer install || true
      cp .env.example .env || true
      php artisan key:generate || true
    '';
  };
}