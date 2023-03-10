# Google Fonts Downloader

Download all Google Fonts using [google-webfonts-helper](https://gwfh.mranftl.com/fonts) API by [Mario Ranftl](https://mranftl.com/).

## Usage

### Install

```shell
composer install
```

### Commands

#### Start download

```shell
php gfonts
```

#### Force overwrite exist ZIP files

```shell
php gfonts --force
```

#### Change delay download execution in microseconds

```shell
php gfonts --sleep=400000
```

#### Unzip Fonts

```shell
php gfonts unzip
```

#### Unzip Fonts and delete ZIP archives

```shell
php gfonts unzip --delete
```

#### Create CSS file for each font

```shell
php gfonts create:css
```

### Customize folder and filename

#### Target folder

Edit `$targetDir` in [src/Console/Commands/DownloadCommand.php](src/Console/Commands/DownloadCommand.php)

#### Target filename

Edit `$filename` in [src/Console/Commands/DownloadCommand.php](src/Console/Commands/DownloadCommand.php)

---


[![Stand With Ukraine](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/banner2-direct.svg)](https://vshymanskyy.github.io/StandWithUkraine/)

[![Woman. Life. Freedom.](https://raw.githubusercontent.com/Muetze42/Muetze42/2033b219c6cce0cb656c34da5246434c27919bcd/files/iran-banner-big.svg)](https://linktr.ee/CurrentPetitionsFreeIran)
