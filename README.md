jira_report_generator
=====================

Automates getting monthly reports from JIRA.

How to use:

```
docker run -e JIRA_USER=username \
    -e JIRA_PASS=password \
    -e JIRA_SERVER='https://your-project.atlassian.net' \
    -e YANDEX_TOKEN='token_provided_by_yandex' \
    -v $PWD:/code/reports \
    --name=jrd --rm kertis/jira_report_generator
```

The project uses [Yandex Translate API](https://translate.yandex.ru/developers).

[Obtain API Key here](https://translate.yandex.ru/developers/keys)
