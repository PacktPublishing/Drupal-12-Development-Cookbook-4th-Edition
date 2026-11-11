# Chapter 5 — AI-Powered Drupal Development

Reference code for the two recipes in this chapter that produce uploadable files. All content is reproduced exactly as printed in the chapter manuscript. The other three recipes (Installing and configuring the Drupal AI module; Adding AI suggestions to the content authoring experience; Embedding AI tools in the CKEditor 5 toolbar) are UI/configuration walkthroughs with no code files to reproduce.

## Recipe 4 — Calling the Drupal AI API from custom code

A complete custom module, `ai_tldr`, that adds a block summarizing the current node into a one-sentence "TL;DR" via the Drupal AI API.

- `recipe4/ai_tldr/ai_tldr.info.yml` — module info file (`core_version_requirement: ^12`, dependencies on `drupal:ai` and `drupal:node`)
- `recipe4/ai_tldr/src/Plugin/Block/AiTldrBlock.php` — the `AiTldrBlock` block plugin using the `#[Block]` attribute, `#[Autowire]` constructor injection of the `ai.provider` service, and a `build()` method that calls `ChatInput`/`ChatMessage` and the provider's `chat()` method

Install location on a real site: `web/modules/custom/ai_tldr/`.

## Recipe 5 — Setting up your Drupal project for AI coding agents

Project-root context and config files that help AI coding agents produce accurate Drupal 12 code, plus a validation script.

- `recipe5/CLAUDE.md` — Claude Code project context file (printed in full)
- `recipe5/AGENTS.md` — cross-tool AI agent instructions (printed in full)
- `recipe5/scripts/validate.sh` — PHPCS + PHPStan validation script (printed in full; run `chmod +x scripts/validate.sh` to make it executable)
- `recipe5/phpstan.neon` — minimal PHPStan configuration at level 5 (printed in full)

### Not reproduced (only mentioned, not printed in full)

- `.cursorrules` (for Cursor) — the chapter only says to "create a `.cursorrules` file in the project root with similar content" to `CLAUDE.md`; no full contents are printed, so no file is included here.
- `.github/copilot-instructions.md` (for GitHub Copilot) — likewise only mentioned as having "similar content"; the chapter states "only the filename and exact format differ." No full contents are printed, so no file is included here.

## Drupal 12 testing notes

- Tested on Drupal 12.0.0-beta2 (PHP 8.5). `composer require drupal/ai drupal/key` does not resolve: `drupal/ai` 1.4.x/1.5.x require `drupal/core ^10.5 || ^11.2`. Until the AI module declares Drupal 12 support, the `ai_tldr` module cannot be installed with a stock Composer workflow on Drupal 12.
- `ai_tldr` lists `core_version_requirement: ^12`; it parses, installs, and its block renders correctly when the AI module is made installable on a test site (info.yml constraint widened locally). With no default chat provider it shows "No default chat provider configured."; with a provider it renders the summary.
- Install Drush 14 (not 13) for the Drush commands in the chapter; the `CLAUDE.md` template now says Drush 14.
