<?php
/**
 * Change this before using the French sentence log or the Papers uploader.
 * Anyone who knows this passphrase can add entries to either — it is a
 * lightweight deterrent against casual/bot spam, not real authentication,
 * so don't reuse a password you use elsewhere.
 *
 * Both features share this one constant on purpose (one password to
 * remember). If you'd rather they use different passphrases, define a
 * second constant here (e.g. PAPERS_PASSPHRASE) and reference it in
 * papers/index.php instead of CONTENT_PASSPHRASE.
 */
if (!defined('CONTENT_PASSPHRASE')) {
    define('CONTENT_PASSPHRASE', 'change-me');
}

