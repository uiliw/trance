<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa user o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações
// com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'trancev2');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 'askme');

/** Nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Charset do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'TkYB*4h8IR&i`o,V5UQU}.>3S}e.}|:*{Zj4xG4FS,l7Iw2iD&aCEuzU,ywe@nmA');
define('SECURE_AUTH_KEY',  ')C_-PK_-`~TLjo|P.:S(Co?ZomTR(m@ji[/dVJcE]_2RS::bR0tjX/rrJ ;[x7`|');
define('LOGGED_IN_KEY',    'rRW,YPAR-a+KUCKmBMur7NZbOCP=/6rD@4dX-}g?3@W?7v:-!|F/aC =Wwm+P}@J');
define('NONCE_KEY',        'AfIzqO)Cfz5e6t7LK+o0!3bgd1mRd/#RH|/*U([L9zc)lv#z<;)`}nf8Os>bQlT?');
define('AUTH_SALT',        'l2#HGhYU%J4kDT~yvU5i>;aAxlJ>&|;#8$DIRmi*e3OeOVHu8ud+gJE)<|h&Mc=+');
define('SECURE_AUTH_SALT', 'b:K+Sl%~b@JtF#4Eul$i.urkj*>L8FVu(EyAofwP`Mbpwj]CoQ$_s4M&[EhHZ{mD');
define('LOGGED_IN_SALT',   '$*YKF9[3NAVzDnMCmP:r7qGH2HIOq+trH_1MbC8>/_4OI<fE/jWE<3p{Ls-?$KrS');
define('NONCE_SALT',       ']a=KD~9^r%=D-Q-UW|$m.OE`3i,+ p,T$o;Z~nxaaL;H?RnVoWvlHx@D~:=62C<,');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * para cada um um único prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';

/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
