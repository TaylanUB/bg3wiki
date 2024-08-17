#!/bin/sh

if ! [ "$(pwd)" = /root/repo/bg3wiki ];
then
    echo >&2 'Run this from /root/repo/bg3wiki!'
    exit 1
fi

for arg
do
    case $arg in
        (-p)
            passwords=yes
            ;;
        (*)
            echo >&2 'Invalid arguments.'
            exit 1
    esac
done

find etc var -type f -exec sh -c 'for file; do cp -a /"$file" "$file"; done' -- {} +

if [ "$passwords" ]
then
    (cd /root; tar -czf- pwd) \
        | openssl aes-256-cbc \
                  -md sha512 \
                  -pbkdf2 \
                  -iter 100000 \
                  -pass file:/root/pwd/meta \
                  -in - \
                  -out pwd.enc
fi

echo
echo '~~~~~~~~~~~~~~~~~~~~~'
echo '~~ !!! WARNING !!! ~~'
echo '~~~~~~~~~~~~~~~~~~~~~'
echo
echo 'Do not forget to redact sensitive information from the repo.'
echo
echo 'Use "git diff" and go through all new content to ensure that'
echo 'no passwords, hash salts, or other secret tokens are included.'
echo
