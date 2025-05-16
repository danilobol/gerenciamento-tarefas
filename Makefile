.PHONY: tests
all: help
SHELL=bash

# Absolutely awesome: http://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
help: ## mostrar esta ajuda
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-24s\033[0m %s\n", $$1, $$2}'

.env:
	cp .env.example .env

fix-permissions: ## corrigir diretórios e permissões de arquivo
	sudo cli/fix-permissions

docker-build: ## build do Dockerfile e sobe os containers
	docker compose up -d --build --remove-orphans $(images)

up: ## Para rodar o servidor depois do setup
	docker compose up -d

migrate: ## executar as migrations
	docker compose exec server php artisan migrate

admin-user: ## cria usuário admin
	docker compose exec server php artisan db:seed --class=AdminUserSeeder

swagger: ## Gerar a documentação swagger
	docker compose exec server php artisan l5-swagger:generate

setup: .env docker-build migrate admin-user swagger ## Executa a configuração completa do ambiente e so precisa executar uma vez
