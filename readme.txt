=== Sign Pantograph Extension ===
Contributors: bacoor
Donate link: paypal.me/BacoorINC
Tags: login, pantograph, web3, tomo, cryptocurrency, crypto wallet, blockchain
Requires at least: 4.7
Tested up to: 5.4
Stable tag: 4.3
Requires PHP: 5.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Enable login with Pantograph Wallet.

== Description ==

Add the capability to log in with cryptocurrency wallet such as [Pantograph](https://pantograph.io/). Adds a button to WordPress login screen that will let users securely log in with their crypto wallet.

In the background, a regular WordPress user account is created, so existing plugins and customizations will have no problem working along.


== Installation ==

Use WordPress' Add New Plugin feature, search "Sign Pantograph Extension"

or

1. Upload this folder (on WordPress.org, not GitLab) to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= How does it work? =

The outline is described in [this TopTal post by Amaury Martiny](https://www.toptal.com/ethereum/one-click-login-flows-a-metamask-tutorial).

= Are my coins safe? =

Yes. A wallet (e.g. MetaMask) does/should not leak your private keys out into the wild, that would be madness.

== Screenshots ==

1. Login flow.

== Changelog ==

= 0.1.0 =

Initial release 8/2020.

== Upgrade Notice ==

= 0.1.0 =

* Added Pantograph Wallet support and a deep link to login screen.

== Details ==

= Shortcodes =

`[sign_panto_button]`

Inserts a login button. The same kind as you see on the login screen.

The button will only be displayed if user is *not* logged in, otherwise outputs nothing.