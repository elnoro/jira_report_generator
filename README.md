jira_report_generator
=====================

Automates monthly reports from JIRA

How to use:

```
docker run -e JIRA_USER=username \
    -e JIRA_PASS=password \
    -e JIRA_SERVER='https://your-project.atlassian.net' \
    -e YANDEX_TOKEN='token_provided_by_yandex' \
    -v $PWD:/code/reports \
    --name=jrd --rm kertis/jira_report_generator
```