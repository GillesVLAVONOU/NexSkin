# AGENTS.md — Règles de développement du projet

**Fichier unique de référence.** Toutes les règles et conventions à respecter sur ce projet sont ici.

## Règles d'utilisation de ce fichier

1. **Consulter AGENTS.md en premier.** Avant d'analyser, modifier ou ajouter du code lors de toute nouvelle tâche, lire ce fichier.
2. **Respecter toutes les règles** définies ci-dessous, quelle que soit la taille de la tâche.
3. **Signaler les conflits.** Si une règle entre en conflit avec une demande explicite de l'utilisateur, signaler le conflit **avant** de modifier le code, et attendre décision.
4. **Ne jamais modifier AGENTS.md automatiquement** pour contourner une règle.
5. **Proposer avant d'ajouter.** Toute nouvelle convention importante doit être proposée à l'utilisateur avant d'être intégrée à ce fichier.
6. **Aucune exception par simplicité.** Une tâche « simple » n'autorise pas à ignorer ce fichier.

---

## 1. PRINCIPES GÉNÉRAUX

- **Respecter l'architecture et les conventions existantes** du projet avant toute chose.
- **Réutiliser avant de créer** : rechercher le code existant (fonctions, composants, helpers, services) pouvant être réutilisé avant d'écrire du nouveau.
- **Ne jamais réécrire inutilement** un fichier fonctionnel.
- **Ne jamais supprimer une fonctionnalité existante** sans raison valable et sans en informer explicitement l'utilisateur.
- **Ne jamais inventer** une structure de projet, une table, une route ou une API qui n'existe pas. En cas de doute, vérifier dans le code ou demander.
- **Ne jamais ajouter une dépendance sans justification** expliquée (gain réel, alternative évaluée).
- **Ne jamais exposer de secrets** : mots de passe, clés API, tokens, chaînes de connexion, credentials.
- Privilégier un code **simple, lisible, modulaire et maintenable**.
- **Éviter la duplication** de code (DRY) sans pour autant créer des abstractions prématurées (KISS / YAGNI).
- **Responsabilité unique** (SRU) quand pertinent : une fonction, une classe, un fichier = une raison de changer.
- **Noms explicites** pour variables, fonctions, classes, fichiers, routes et colonnes de base de données.
- **Séparer présentation, logique métier et accès aux données** lorsque l'architecture du projet le permet.
- Cohérence avant optimisation : un code clair vaut plus qu'un code « malin ».

## 2. ANALYSE DU PROJET AVANT CODAGE

Avant d'écrire la moindre ligne de code :

1. **Explorer la structure** : répertoires, entrées principales, fichiers de configuration, README, fichiers de règles existants.
2. **Identifier la stack réelle** (langages, framework, version, gestionnaire de dépendances, build).
3. **Repérer les conventions** : nommage, indentation, structure des dossiers, gestion des erreurs, style des commentaires, chemins de routes.
4. **Rechercher du code réutilisable** : helpers, services, middlewares, composants, utilitaires déjà présents.
5. **Vérifier l'outillage** : linters, formateurs, tests, scripts (package.json, composer.json, Makefile, etc.).
6. **Rechercher des règles complémentaires** : CLAUDE.md, .cursorrules, CONTRIBUTING, .editorconfig, .eslintrc, php-cs-fixer, Pint.
7. **Comprendre la demande** : objectif métier, périmètre, contraintes, données concernées.

Pour une **tâche complexe** : analyser d'abord, puis **proposer un plan** (étapes, fichiers impactés, risques) avant d'effectuer les modifications. Attendre l'accord si le plan implique des changements structurels ou destructeurs.

## 3. ARCHITECTURE ET STRUCTURE DU CODE

- **Respecter l'architecture existante** : ne pas déplacer, renommer ou restructurer sans nécessité ni accord.
- Respecter les schémas de séparation de responsabilités du framework utilisé :
  - **PHP / Laravel** : routes → contrôleurs → services/repositories → modèles (Eloquent) → vues/blade. Respecter les middlewares, Form Requests, Resources, Policies.
  - **Java** : couches controller / service / repository, entités et DTO distincts.
  - **Flutter / Dart** : widgets (UI), providers/state (logique), repositories/models (données).
  - **Frontend** : composants, styles, scripts organisés de façon cohérente avec le projet existant.
- Placer chaque nouveau code à **l'endroit où il serait cherché** par un développeur du projet.
- **Une responsabilité par fichier** ; découper quand un fichier devient long ou multiple responsabilités.
- **Chemins et casse** : toujours vérifier la casse exacte (crucial sous Linux) ; ne pas générer de conflit de casse.
- **Configuration** : séparer les valeurs variables/environnementales du code (`env`, `.env`, config du framework) ; ne jamais coder en dur ce qui relève de la configuration.
- **Constantes et énumérations** plutôt que chaînes magiques répétées.
- Si le projet n'a pas de structure claire, **proposer une organisation** plutôt que l'imposer.

## 4. QUALITÉ DU CODE

- **Lisibilité d'abord** : blocs de code courts, fonctions courtes, une idée par fonction.
- **Nommage explicite** : `calculateInvoiceTotal()` plutôt que `calc()` ; `isSubscribed` plutôt que `flag`.
- **Éviter les effets de bord** cachés ; préférer les fonctions prévisibles.
- **Pas de duplication** : extraire un helper/service quand la logique revient à 3+ endroits (2 fois : évaluer).
- **Pas de code mort** : ne pas laisser de code commenté volumineux, de variables inutilisées ou de fonctions orphelines.
- **Commentaires** : uniquement pour expliquer le **« pourquoi »** quand il n'est pas évident. Ne pas commenter ce qui est évident, ni ajouter de commentaires inutiles (bannières de fichier, changelog dans le code).
- **TODO** : autorisés seulement avec un identifiant/ticket clair ; ne pas laisser de TODO « à l'ancienne » dans une livraison sans le signaler.
- **Constantes magiques** : à nommer.
- **Complexité** : éviter les fonctions profondément imbriquées (max ~3 niveaux) et les suites de plus de 3 branches (préférer stratégie/mapping).
- **Cohérence de style** : suivre le formateur/linter existant (Prettier, PHP-CS-Fixer/Pint, PSR-12, ESLint, Checkstyle, `dart format`, Tailwind config).
- **Typage** : utiliser les types disponibles (PHP 7/8 type hints, PHPDoc, Java types, Dart null-safety, TypeScript) plutôt que de deviner à la lecture.

## 5. FRONTEND

### Général
- **Respecter la structure et le style existants** (Tailwind, Bootstrap, CSS maison, méthode BEM, etc.) ; ne pas mixer plusieurs systèmes de style dans un même écran sans accord.
- **Sémantique HTML** : `header`, `nav`, `main`, `section`, `article`, `form`, `button`, `label`. Pas de `<div>` partout quand un élément sémantique existe.
- **Accessibilité (a11y)** : `lang`, titres hiérarchisés (un seul `h1`), labels associés aux champs (`for`/`id`), `aria-*` quand nécessaire, navigation clavier, focus visible, contrastes AA, `alt` des images (ou `alt=""` pour décoratives).
- **Responsive** : mobile-first, grilles/fluides, tester les points de rupture ; éviter les largeurs fixes.
- **Performance** : images dimensionnées et compressées (WebP/AVIF), `loading="lazy"` hors écran, scripts en `defer`/`async` si possible, CSS critique minimal, pas de bibliothèque lourde pour une fonction triviale.
- **Pas de bibliothèque UI lourde ajoutée sans justification** (éviter d'ajouter un framework si le projet a déjà un système).

### JavaScript
- **Vanilla par défaut** quand le projet le permet ; respecter le module système utilisé (ES modules, bundler, script global, jQuery si présent).
- **Pas de variable globale** : encapsuler (IIFE, module, `const`/`let` jamais `var`).
- **Éviter le code inline** dans les vues/template au-delà de données de départ (préférer `data-*` + script).
- **Éviter `any` implicite** (TypeScript si présent) et les casts hasardeux.
- **Gérer les cas limites** : listes vides, champs optionnels, erreurs réseau, états de chargement.
- **Accessibilité des composants** : boutons utilisables au clavier, `aria-*` pour menu/onglets modaux, piège de focus dans les modales, `prefers-reduced-motion`.
- **Validation côté serveur obligatoire** ; la validation JS est un confort d'interface, pas une sécurité.

### CSS / Tailwind / Bootstrap
- **Suivre la méthodologie existante** (BEM, utility-first, composants, CSS modules, SCSS).
- **Tailwind** : respecter la config (`tailwind.config.js`), ne pas utiliser de classes arbitraires inutilement, éviter les `@apply` abusifs, purger correctement.
- **Bootstrap** : ne pas surcharger les classes du framework par défaut sans échantillon ; préférer les utilitaires Bootstrap ou un thème cohérent.
- **Éviter `!important`** sauf cas isolé justifié.
- **Variables de design** : couleurs, espacements, typographies dans les variables/tokens existants plutôt que des valeurs en dur répétées.
- **`z-index`** : géré par variables/échelle si le projet en a une ; éviter les valeurs arbitraires très élevées.
- **Responsive** : privilégier flex/grid ; éviter les `float` et le positionnement absolu pour la mise en page principale.

## 6. BACKEND

- **Valider et assainir toutes les entrées** côté serveur (toutes les sources utilisateur : GET, POST, JSON, upload, headers, cookies, webhooks).
- **Ne pas faire confiance au client** : jamais de donnée « déjà validée côté JS ».
- **Logique métier dans le bon niveau** : contrôleurs fins (routage/validation/appel), services pour la logique, repositories/models pour la donnée.
- **Requêtes** : utiliser les ORM/constructeurs du framework (Eloquent, Query Builder) plutôt que du SQL brut ; si SQL brut nécessaire, requêtes préparées exclusivement.
- **Manipulation des dates/heures** : timezone explicite (UTC au stockage), format de sortie cohérent.
- **Arbitrage** : privilégier des fonctions purement testables ; isoler les effets (I/O, mail, API externe) derrière des services.
- **Secrets** : jamais en dur ; variables d'environnement ou gestionnaire de secrets (Laravel `config()` + `.env`, Vault, etc.).
- **Upload de fichiers** : valider type (MIME réel), taille, nom ; stocker hors racine web exécutable ; renommer ; ne jamais se fier à l'extension.
- **Tâches longues** : file/queue/worker plutôt que des requêtes HTTP longues quand le projet le supporte.
- **Journalisation** : logs structurés utiles (erreurs, contexte), sans informations sensibles (pas de mots de passe, tokens, données bancaires, PII en clair).
- **Limiter les effets de bord** : transactions pour les opérations multi-écritures.
- **PHP** : vérifier les fonctions dangereuses (`eval`, `system`, `exec`, `unserialize` sur entrée utilisateur) ; ne pas les utiliser avec des données non fiables.

## 7. BASE DE DONNÉNES

- **Respecter le schéma existant** : noms de tables/colonnes, conventions (snake_case, prefix), types et index existants.
- **Migrations** : créer une migration plutôt que de modifier le schéma en production manuellement ; réversible quand c'est possible ; ne jamais fusionner/supprimer une migration déjà déployée sans accord.
- **Écrire des requêtes préparées / liaisons de paramètres** uniquement — jamais de concaténation de chaînes dans une requête (protection SQL Injection).
- **Index** : indexer les colonnes utilisées en `WHERE`, `JOIN`, `ORDER BY` ; évaluer le coût des requêtes N+1 (eager loading Eloquent, `JOIN` ou cache).
- **Intégrité** : clés primaires/étrangères, `NOT NULL` pertinent, contraintes d'unicité, `ON DELETE` explicite.
- **Éviter le stockage de données dérivées** quand elles peuvent être calculées ; à l'inverse, dénormaliser volontairement si le projet le fait déjà.
- **Pas de données sensibles en clair** : mots de passe hachés (bcrypt/argon2), tokens chiffrés, données chiffrées si requis (RGPD).
- **Transactions** pour les opérations atomiques multi-tables.
- **Migrations/rollback** : tester localement, prévoir le retour arrière, préserver les données existantes.
- **Suppression de données** : soft-delete si le projet l'utilise ; **jamais de `DELETE`/`TRUNCATE`/`DROP` non réversible sans confirmation explicite**.
- **Compatibilité SQL** : connaître les différences MySQL vs PostgreSQL (auto-incréments, casse, types JSON, fonctions) avant d'écrire du SQL portable.

## 8. API

- **Respecter le style API existant** (REST, GraphQL, RPC) : verbes, noms de routes, versions, format de réponse.
- **REST** : verbes HTTP sémantiques (`GET` lecture, `POST` création, `PUT/PATCH` mise à jour, `DELETE` suppression) ; codes HTTP corrects (200/201/204/400/401/403/404/409/422/500).
- **Réponses cohérentes** : format unique (JSON), structure d'erreur constante, pagination/limites prévues.
- **Versionner** si le projet le fait (`/api/v1/...`) ; ne pas casser un contrat existant sans versionner ni prévenir.
- **Documentation** : mettre à jour la doc (OpenAPI/Swagger, README) quand on change un contrat.
- **Validation** des entrées (FormRequest / DTO / schema) et **autorisation** (policies/guards) sur chaque endpoint.
- **Rate limiting** sur les endpoints sensibles ou coûteux.
- **Authentification** : supporter les standards du projet (session, Sanctum, Passport/JWT, OAuth) ; tokens en `Authorization`, jamais dans l'URL ni en clair.
- **Idempotence** : endpoints de suppression/mise à jour gérés proprement.
- **Webhooks** : vérifier signatures, gérer rejeux, ne pas exposer de données superflues.
- **CORS** : restreint à l'origine nécessaire.
- **Ne pas inventer un endpoint qui n'existe pas** : vérifier les routes/routers réellement déclarés ; en cas de besoin, proposer la création.

## 9. SÉCURITÉ

Considérations systématiques à chaque traitement de données utilisateur :

- **SQL Injection** : uniquement requêtes préparées / ORM ; jamais de concaténation.
- **XSS (Cross-Site Scripting)** : échapper à l'affichage (Blade `{{ }}` vs `{!! !!}`, framework front, `textContent` vs `innerHTML`, `htmlspecialchars`). Préférer le templating auto-échappant ; éviter `v-html`, `{!! !!}`, `dangerouslySetInnerHTML`, `.innerHTML` avec des données utilisateur.
- **CSRF** : jetons sur tous les formulaires/mutations (Laravel `@csrf`, cookies SameSite, tokens anti-CSRF côté API).
- **Authentification** : mots de passe hachés forts, politique de mot de passe, limitation des tentatives, sessions/cookies `HttpOnly`/`Secure`/`SameSite`, expiration, régénération d'ID de session.
- **Autorisation** : vérifier les droits **côté serveur à chaque requête** (Policies, Gate, rôles, gardes). Jamais uniquement masquer un bouton. Ne jamais se fier à un ID passé par le client pour accéder à une ressource.
- **Validation des entrées** : whitelist (types, longueurs, formats) plutôt que blacklist.
- **Exposition de données sensibles** : pas de mots de passe, tokens, clés API, données personnelles dans les réponses, logs, `debug`, stacktraces ni JSON public. Filtrer les champs (`$hidden`, sérialisation fine).
- **Upload de fichiers** : valider le type réel, la taille, générer un nom sûr, stocker hors webroot, servir en `Content-Disposition` adapté, bloquer exécution des fichiers uploadés.
- **Énumération/rate limiting** : limiter les tentatives de connexion, éviter de révéler si un compte existe.
- **Injection de commandes / path traversal / deserialization** : ne pas passer de données utilisateur à `exec`, `system`, `file_get_contents` avec chemin concaténé, `unserialize`, `include` dynamique.
- **Dépendances** : garder à jour, surveiller les CVE (audit `composer audit`, `npm audit`, Dependabot).
- **HTTPS** forcé en production ; HSTS si possible.
- **En-têtes de sécurité** : `Content-Security-Policy`, `X-Content-Type-Options`, `X-Frame-Options`, etc. si le projet les met en place.
- **RGPD/minimalisation** : ne collecter que le nécessaire ; gérer effacement/anonymisation sur demande.
- **Balisage** : `rel="noopener"` (ou `noreferrer` si pertinent) pour les liens `target="_blank"`.

## 10. GESTION DES ERREURS

- **Toujours gérer les erreurs** : pas de bloc silencieusement ignoré (`catch` vide, `@` suppression d'erreurs).
- **Messages exploitables** pour les développeurs (contexte, IDs, entrées pertinentes), **messages génériks** pour l'utilisateur final.
- **Logs** : niveaux cohérents (`debug/info/warning/error`), erreurs attendues = warning/info, inattendues = error/critique.
- **Ne jamais afficher de stacktrace / debug** à l'utilisateur en production.
- **Propager ou capturer avec intention** : capturer seulement si on peut traiter (traduire en réponse métier, réessayer, journaliser) ; sinon laisser remonter.
- **Réponses d'erreur structurées** côté API (code, message, détails valides).
- **Codes retour** : PHP — utiliser exceptions plutôt que `false` silencieux ; Dart — exceptions typées ; JS — `Promise` rejetées gérées, `async/await` avec `try/catch`.
- **Échec gracieux** : états de chargement, états vides, messages d'échec compréhensibles, possibilité de réessayer quand pertinent.
- **Réessais** : uniquement sur erreurs transitoires (réseau, timeout), avec backoff borné, jamais indéfini.
- **Idempotence** : en cas de réessai sur mutation, éviter les effets en double.
- **Entrées utilisateur invalides** : codes 422/400 + erreurs de champ ciblées (formulaire) plutôt qu'une erreur 500.

## 11. DEBUGGING

- **Cause racine, pas le symptôme** : comprendre pourquoi ça casse avant de corriger.
- **Pas de « patch » qui masque** : ne pas comment-out, ne pas ignorer l'erreur, ne pas ajouter de `try/catch` vide, ne pas augmenter un timeout sans le diagnostiquer.
- **Méthode** : reproduire → isoler (bisect du changement, désactiver par morceaux, mini-cas) → hypothèses → vérifier → corriger → confirmer.
- **Outils** : logs structurés, `dump`/`dd` (retirés après), debuggers, DevTools réseau, SQL query log, profilers, `assert`.
- **Vérifier l'environnement** : versions, `.env`, cache, permissions, variable d'environnement manquante, différence dev/prod.
- **Comparer** : « ça marchait avant » → identifier la modification responsable (`git log`, `git diff`, blame).
- **Après correction** : vérifier la cohérence du code environnant, rechercher les **régressions possibles** (autres endroits qui utilisent la fonction, cas limites, frontières de la donnée).
- **Reproduire en local avec le minimum de données** ; documenter la cause si elle est non évidente.
- **Régler définitivement** : si le bug vient d'une règle/limite, ajouter un test de non-régression plutôt que de corriger seulement le cas observé.

## 12. GESTION DES DÉPENDANCES

- **Justifier toute nouvelle dépendance** : problème résolu, alternatives (native/interne) évaluées, coût (taille, maintenance, licence).
- **Préférer le standard/le natif** à une lib quand le langage le couvre (PHP natif, Dart SDK, JS sans lib).
- **Versions** : gérer via le gestionnaire officiel (`composer`, `npm`/`yarn`/`pnpm`, `pub`, `gradle`/`maven`, `pubspec.lock`) ; **jamais de librairie copiée à la main**.
- **Committer les fichiers de lock** ; ne pas le régénérer entièrement sans raison.
- **Respecter la compatibilité** : version du langage/framework, conflits, contraintes du serveur.
- **Mises à jour** : ciblées, justifiées, testées ; pas de « upgrade for the upgrade » sans besoin.
- **Suppression** : retirer la dépendance devenue inutile (config, imports, code mort) quand on l'enlève.
- **Sécurité** : audits (`composer audit`, `npm audit`), corriger les CVE critiques en priorité.
- **Outillage dev** (linters, tests, formateurs) à distinguer des dépendances de production.

## 13. GIT ET GITHUB

- **Jamais de commande destructive sans autorisation explicite** : `git reset --hard`, `git clean -fd`, `git push --force` (sauf `--force-with-lease` discuté), réécriture d'historique (`rebase` de branche partagée, `filter-branch`), suppression de branche/remote, `git checkout -- <fichier>` écrasant des modifications locales.
- **Demander avant** toute opération destructive ou difficile à annuler ; confirmer la suppression/écrasement de données.
- **Avant de commiter** : relire le diff (`git status`, `git diff`) et ne commiter que les changements liés à la tâche.
- **Messages de commit** : clairs, dans la langue/convention du projet (Conventional Commits `feat:`, `fix:`, `chore:` si utilisés).
- **Une intention par commit** ; éviter les commits fourre-tout.
- **Pas de secrets dans l'historique** : vérifier avant commit (`.env`, clés, tokens) ; `.gitignore` à respecter/compléter si besoin (avec justification).
- **Ne pas commiter** : artifacts de build, dépendances (vendor/node_modules), fichiers générés, IDE/OS (sauf si le projet les versionne).
- **Branche** : suivre le workflow existant (trunk/main, feature branches, PR) ; ne pas pousser direct sur la branche protégée.
- **Avant fin de tâche** : `git status` propre (pas d'accidentel), diff lisible, `git pull --rebase` si la convention du projet l'utilise.
- **Conflits** : les résoudre en comprenant les deux côtés, jamais en choisissant aveuglément un côté.
- **Pas de `git commit -a` aveugle** ; pas de commit d'un fichier non lié (« convenance »).

## 14. TESTS ET VALIDATION

- **Exécuter les tests/linters/validations disponibles** quand la tâche le concerne (et avant de conclure quand c'est pertinent).
- **Taper les tests existants** : unitaires, intégration, fonctionnels, feature ; suivre les conventions (`tests/Feature`, `*Test.java`, `*_test.dart`, `__tests__`).
- **Un test par comportement** ; nom explicite (`should_throw_when_email_is_invalid`).
- **Couvrir les cas limites** : listes vides, null/nil, valeurs extrêmes, erreurs réseau, doublons, frontières de permission.
- **Validation manuelle** : vérifier le scénario principal, responsive si frontend, erreurs si API.
- **Régression** : après modification, chercher ce qui pourrait casser ailleurs (utilisateurs de la fonction modifiée).
- **Pas de tests sans valeur** (test qui ne peut pas échouer) ; ne pas désactiver un test pour faire passer la CI — comprendre et corriger.
- **Couverture** : viser la logique métier critique (autorisation, calculs, transitions d'état).
- **Différents langages** : PHPUnit/Pest, JUnit, `flutter test`/`dart test`, Jest/Vitest, Playwright/Cypress ; utiliser ceux déjà en place.
- **Formatage/static analysis** : `pint`/`php-cs-fixer`, PHPStan/Psalm, ESLint/Prettier, `dart analyze`, `dart format`, Checkstyle.
- **Qualité de build** : `npm run build`/`vite build`, `mvn package`, `flutter build` ne doivent pas être cassés.

## 15. PERFORMANCES

- **Mesurer avant d'optimiser** (profilers, Lighthouse, débogueur SQL, `EXPLAIN`) ; ne pas optimiser au hasard.
- **Côté serveur** : requêtes N+1 à éviter (eager loading), index, cache (Redis/Memcached, `Cache::`, annotations de cache) quand c'est justifié, pagination systématique des listes.
- **Côté front** : dimensionner les images, `loading="lazy"`, lazy-loading des composants, code splitting si le projet le fait, limiter les re-renders, éviter les boucles de rendu coûteuses.
- **Bundle/JS** : ne pas importer une lib entière pour une fonction ; vérifier le poids ajouté.
- **Concurrence** : files/queues pour les tâches longues (mail, export, traitement) ; timeouts raisonnables.
- **Redondance** : éviter les calculs répétés dans une requête (compter dans SQL, pas en PHP).
- **Budgets** : respecter les budgets/perf du projet s'il en a (LCP, taille bundle).
- **Sécurité vs perf** : pas de court-circuit de sécurité pour gagner des ms.
- **Régression de perf** : surveiller quand on ajoute des boucles, requêtes ou rendus par itération.

## 16. DOCUMENTATION

- **Tenir à jour les docs impactées** : README, doc API (OpenAPI/Swagger), commentaires de routes, `CHANGELOG` (si présent), wikis.
- **Lisibilité par un nouveau** : structure, installation, lancement, configuration.
- **Config obligatoire documentée** : variables d'environnement, prérequis (versions), commandes utiles.
- **Code commenté** : seulement le « pourquoi » non évident ; une intention par commentaire.
- **Publique vs interne** : éviter de documenter ce qui est éphémère ; documenter ce qui dure (architecture, invariants, décisions structurantes).
- **ADR** (Architecture Decision Records) pour les décisions structurantes si le projet les utilise.
- **Documentation des API** : exemples, codes d'erreur, auth requise.
- **À la fin de la tâche** : signaler toute doc à mettre à jour (et la mettre à jour si elle est dans le périmètre).

## 17. RÈGLES POUR LES MODIFICATIONS DE CODE

- **Préserver le fonctionnel** : ne pas écraser/regénérer un fichier qui fonctionne par un export entier du fichier — privilégier une modification ciblée.
- **Modifier le minimum** nécessaire pour atteindre l'objectif ; éviter le refactoring périphérique non demandé (sauf à le proposer).
- **Signaler avant de supprimer** toute fonctionnalité, configuration, route, colonne ou fichier existant — et obtenir un accord.
- **Ne pas mélanger** une tâche de feature avec un refactoring de style dans le même commit/diff.
- **Respecter le style du fichier** que l'on modifie (indentation, casse, structure, langue des commentaires).
- **Conserver le comportement public** : signatures, formats de réponse, contrats d'API — ou annoncer la rupture explicitement.
- **Après modification** : relire le diff en entier, vérifier la cohérence avec le reste, chercher les régressions, lancer les validations pertinentes.
- **Impact large** (déplacement/renommage, changement de schéma, changement d'API) : annoncer, lister les fichiers, proposer un plan avant d'agir.
- **Reproductibilité** : éviter les modifications « magiques » non vérifiables ; préférer la solution testable.
- **Pas de code exploratoire laissé** : retirer les expérimentations, prints de debug, commentés temporaires.
- **Confirmation** : si l'opération est potentiellement destructive (écrasement de données, suppression, migration), demander une confirmation explicite.
- **Compatibilité** : si une règle d'AGENTS.md est en conflit avec la demande, **signaler avant** de modifier ; ne jamais trancher en silence.

## 18. COMPORTEMENT DE L'AGENT

- **Toujours lire AGENTS.md en premier** ; le respecter intégralement, sans exception.
- **Signaler les conflits** entre une règle et une demande avant de coder ; attendre la décision.
- **Ne jamais modifier AGENTS.md** de sa propre initiative ; toute nouvelle convention doit être **proposée** puis approuvée.
- **Poser des questions** quand la demande est ambiguë (périmètre, données, environnement) plutôt que d'inventer.
- **Tâche complexe** : analyser d'abord, proposer un plan, attendre l'accord si des changements structurels/destructeurs sont impliqués.
- **Ne rien inventer** : structure, API, table, endpoint, configuration ou option qui n'existe pas dans le code — vérifier ou demander.
- **Remettre en question un travail existant** (fichiers non créés par l'agent) : examiner avant de le remplacer ou le supprimer.
- **Prévenir avant toute action destructive** ; jamais de commande Git destructive sans autorisation.
- **Honorer les délais et la précision** : ne pas promettre ce qui n'est pas réalisable ; signaler les limites.
- **Langue** : répondre dans la langue de l'utilisateur ; garder le code et les identifiants en anglais, la documentation/commentaires dans la langue du projet existant.
- **Candeur** : dire ce qui a fonctionné, ce qui n'a pas fonctionné, ce qui reste à vérifier.
- **Accessibilité et sécurité** dans chaque livraison front/backend.
- **Validation avant de conclure** : tests, linters, build, vérification manuelle pertinente.
- **Résumé obligatoire en fin de tâche** :

  1. **Ce qui a été modifié** — description courte et factuelle.
  2. **Fichiers concernés** — liste des fichiers créés/modifiés/supprimés.
  3. **Dépendances ajoutées** — le cas échéant, avec justification (ou « aucune »).
  4. **Tests / vérifications effectués** — commandes exécutées, résultats, vérifications manuelles.
  5. **Problèmes restant à résoudre** — limites, points non couverts, questions ouvertes (ou « aucun »).

---

*Ce fichier est la référence principale des conventions du projet. Il ne doit exister aucun autre fichier de règles : toute nouvelle convention doit être proposée ici, après approbation.*
