{
  description = "A basic flake with a shell";
  inputs.nixpkgs.url = "github:NixOS/nixpkgs/nixpkgs-unstable";
  inputs.flake-utils.url = "github:numtide/flake-utils";

  outputs = {
    nixpkgs,
    flake-utils,
    ...
  }:
    flake-utils.lib.eachDefaultSystem (
      system: let
        pkgs = nixpkgs.legacyPackages.${system};
        php = pkgs.php83.buildEnv {
          extensions = {all, ...}:
            with all; [
              bcmath
              # ctype
              curl
              dom
              fileinfo
              filter
              gd
              iconv
              intl
              mbstring
              openssl
              pdo
              pdo_mysql
              session
              simplexml
              sodium
              tokenizer
              xdebug
              xmlreader
              xmlwriter
              zip
              zlib
            ];
          extraConfig = ''
            xdebug.start_with_request = yes
            xdebug.discover_client_host = true
          '';
        };
      in {
        devShells.default = pkgs.mkShell {
          packages = with pkgs; [
            bashInteractive
            php
            php.packages.composer
            pkgs.nodePackages.nodejs
          ];

          # Post-activation hook to symlink PHP to ./.bin directory
          shellHook = ''
            mkdir -p .bin
            ln -sf ${php}/bin/php .bin/php
            ln -sf ${php.packages.composer}/bin/composer .bin/composer
          '';
        };

        # nix run . artisan
        # nix run . vendor/bin/pint
        packages.default = php;

        # nix run .#composer install
        packages.composer = php.packages.composer;

        formatter = nixpkgs.legacyPackages.${system}.alejandra;
      }
    );
}
