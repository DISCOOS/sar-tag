SAR-Tag Application
===================


Build from source
-----------------

1. **<a href="https://github.com/DISCOOS/sar-tag/archive/master.zip">Download latest source</a>** and extract it to `/path/to/sartag/`, **or**
    ```bash
    git clone https://github.com/DISCOOS/sar-tag.git /path/to/sartag/
    ```

2. **Goto /path/to/sartag/app/src/**

    ```bash
    cd /path/to/sartag/app/src
    ```
    
2. **Download latest Composer version into /path/to/sartag/app/src/**

    ```bash
    curl -sS https://getcomposer.org/installer | php
    ```
    
    or if you don't have curl (windows):
    
    ```bash
    php -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"
    ```    

3. **Install dependencies and configure SAR-Tag Application**

    ```php
    php composer.phar install
    ```
    
    Follow the instructions.

Developers
----------

Remember to set correct newline behavior before commiting changes to this repo 
(see [Git help](https://help.github.com/articles/dealing-with-line-endings)). The repo 
is configured to store all files with LF line endings (see .gitattributes), and correct 
behavior is best ensured by setting the correct `--global core.autocrlf` value for your OS. 

**Windows**
```bash
git config --global core.autocrlf true
```
which tells Git to auto-convert CRLF line endings into LF when you commit, and vice 
versa when it checks out code onto your filesystem.

**Mac or Linux**
```bash
git config --global core.autocrlf input
```
which tells Git to convert CRLF to LF on commit but not the other way around.

Troubleshooting
---------------

1. Windows user and command line is fighting you? [Read this](http://php.net/manual/en/install.windows.commandline.php).
