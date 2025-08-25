
# Sistema de Controle de Acesso (PHP + JS)

Este projeto fornece um **index.php controlador** que:
- Verifica se o visitante é humano (prova leve via JS).
- Verifica se o IP está **bloqueado** pelo dashboard.
- Se bloqueado → **redireciona** para uma pasta/URL configurável.
- Se não bloqueado → entrega a **home** que você quiser.

Inclui um **Dashboard** (login simples) para:
- Ver visitantes online (últimos 5 minutos).
- Bloquear / desbloquear IPs.
- Ver registros básicos de acesso.
- Configurar **pasta/URL de redirecionamento** quando bloqueado e **caminho da home**.

## Requisitos
- PHP 7.4+ com SQLite3 habilitado.
- Servidor Apache (opcional `.htaccess`) ou Nginx (ajuste `index.php` como front controller).

## Instalação
1. Envie a pasta para sua VPS (ex.: `/var/www/seusite`).
2. Garanta permissão de escrita em `storage/`:
   ```bash
   chmod -R 775 storage
   ```
3. Acesse `https://seusite/` (o banco será criado automaticamente).
4. Dashboard em `https://seusite/dashboard/` (login padrão: **admin / admin**). **Altere a senha** em *Configurações*.

## Configurações rápidas
- Em **Dashboard → Configurações** defina:
  - **Home** (ex.: `sites/home/index.php` ou outro arquivo seu).
  - **Destino de bloqueio**: pode ser **pasta local** (ex.: `sites/blocked/index.php`) ou **URL externa** (ex.: `https://www.google.com`).

## Como funciona o “humano?”
- Na primeira visita, mostramos uma página de verificação com um JS leve que dispara um endpoint (`/api/mark_human.php`). Após isso, o acesso segue normalmente até expirar a sessão (padrão 2h) ou 7 dias no cookie de confiança.

## Estrutura
```
index.php                      # Controlador principal
includes/
  bootstrap.php                # Bootstrap/autoload e init do banco
  db.php                       # Conexão PDO + migrations
  functions.php                # Funções utilitárias
  guard.php                    # Checagens: humano/bloqueio/logs
dashboard/
  index.php                    # Painel (home) + estatísticas
  login.php                    # Login
  logout.php                   # Logout
  block.php                    # POST bloquear
  unblock.php                  # POST desbloquear
  settings.php                 # Configurações
api/
  mark_human.php               # Marca sessão como humana
  heartbeat.php                # Atualiza "online"
assets/
  human.js                     # Script para prova de humanidade
  style.css                    # Estilos simples
sites/
  home/index.php               # Exemplo de "home"
  blocked/index.php            # Landing de bloqueio
storage/
  data.sqlite                  # Banco de dados (auto-criado)
.htaccess                      # (Opcional) regras básicas
```

## Observações
- Este projeto é um **exemplo pronto** e pode ser adaptado à sua infraestrutura (múltiplos sites em pastas). O `index.php` pode incluir a *home* que você preferir via Configurações.
- Para usar **hosts múltiplos/pastas**, você pode clonar esta pasta como index comum na raiz e apontar `Home` para o arquivo correto de cada site.

Boa utilização! ✨
