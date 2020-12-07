# Skeleton website

Starter package for building websites on top of K2D.CZ CMS

- **Clone** this repository
- **Change origin** of this repository to yours:
	- `$ git  remote  rm  origin`
	- `$ git  remote  add  origin  git@github.com:your/repository.git`
	- `$  git  config  master.remote  origin`
	- `$  git  config  master.merge  refs/heads/master`
- Install **Composer** dependencies - `$ composer install`
- Install **NPM** dependencies - `$ npm install`
- Build front-end **assets**:
	- Development: `npm run start` or `npm run watch`
	- Production: `npm run build`
- **Create file** `app/server/local.neon` from `app/config/local.template.neon` and **configure database connection**
- **Run** `$ php bin/console migration:continue`
- **Enjoy**
