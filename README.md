# Doofinder for PlentyONE

![PlentyONE](https://img.shields.io/badge/PlentyONE-Shop%20(PWA)-1f4eb4?style=flat-square)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

**Transform your PlentyONE search into a conversion machine.** Join thousands of merchants using AI-powered search to increase sales and improve customer experience.

![Doofinder in Action](meta/images/preview_0.png)

[🚀 Get Started for Free](https://www.doofinder.com/en/solutions) | [📖 Full Documentation](https://support.doofinder.com/)

---

## Why Doofinder?

Doofinder turns your basic search bar into an advanced discovery engine. Using AI-powered searchandising and recommendations, we drive measurable gains in conversion and product discovery.

### Key Features

* **AI Smart Search** — Understands intent and handles typos or synonyms effortlessly.
* **Searchandising** — Boost, hide, or pin products to run targeted campaigns.
* **Personalized Recommendations** — Intelligent cross-selling based on real customer behavior.
* **Real-Time Analytics** — Insights into user behavior and search trends.
* **Auto-Indexing** — Your catalog is read from your shop by Doofinder, with no feed to maintain.

---

## 🛠 Installation & Quick Start

1. Install and activate the **Doofinder** plugin in your PlentyONE plugin set, then deploy the set.
2. Open the configuration of the plugin and copy the **Feed URL** and the **Token**.
3. In Doofinder, log in (or sign up for a free trial), add a store, choose **PlentyONE** and paste the Feed URL and the Token.
4. Add the script address that Doofinder shows under **Custom Code**, **External Scripts & Styles** of your PlentyONE Shop (PWA).

Doofinder reads your catalog and creates a search engine for every language of your shop.

**Requirements**

| | Supported versions |
| -- | -- |
| Shop | PlentyONE Shop (PWA) |
| Plugin set | A plugin set that is active in your shop |

---

## 👨‍💻 Development & Maintainer Guide

The plugin has no page. It generates a token and records its feed URL in its own configuration the first time it runs, and serves two endpoints that Doofinder calls with that token.

| Endpoint | Access | What it gives |
| -------- | ------ | ------------- |
| `GET /rest/doofinder/v1/shop` | Token (`X-Doofinder-Token` header) | The web store of the shop as PlentyONE returns it: name, languages and currency |
| `GET /rest/doofinder/v1/feed` | Token (`X-Doofinder-Token` header) | One page of items, each with its variations, as PlentyONE returns them. Required parameters: `lang`, `page`, `per_page` |

* The feed URL and the token are the fields of `config.json`. When the token is empty, the service provider fills both (`ConfigurationGenerator`).
* `TokenGuard` checks the token of every request. A missing token in the configuration is never accepted.
* In Doofinder, the shop is added with the PlentyONE option of the store wizard, which checks the token and installs the store.

### Your own PlentyONE system

PlentyONE builds a plugin from the branch of this repository that your plugin set is linked to. Each developer builds into their own system, from their own machine.

**Set it up once**

1. Link your plugin set in PlentyONE to this repository and to your branch.
2. Copy `.env.example` to `.env` and fill in `PLENTYONE_SYSTEM_ID` (your PlentyONE system id), `PLENTYONE_PLUGIN_SET_ID` (the id of your plugin set), and `PLENTYONE_USERNAME` and `PLENTYONE_PASSWORD` (a user of your system with access to plugin sets). Keep the values between single quotes, as in the example. `.env` is ignored by git.

**Build**

* `make push` pushes your branch and asks PlentyONE to build your plugin set.
* `make build` only asks for the build, for when you have already pushed.

The command waits for the build and prints its errors.

### Releasing

* To release, raise `version` in `plugin.json` and add the entry to `meta/documents/changelog_en.md` and `changelog_de.md`.

---

## Support & Contributing

* **Need Help?** Visit our [Support Portal](https://support.doofinder.com/).
* **Found a Bug?** Please [contact Doofinder Support](https://support.doofinder.com/pages/contact-us).
* **Want to contribute?** PRs are welcome!

**If you find this plugin useful, please give us a ⭐ to support the project!**

## Try Doofinder / Learn more

Ready to improve your store search? [Get started with Doofinder](https://www.doofinder.com/en/solutions).
