#!/usr/bin/env sh

# shellcheck disable=SC2034
export LOXCAN_REPORTER_GITHUB="1"
export LOXCAN_REPORTER_GITHUB_OWNER="${INPUT_OWNER}"
export LOXCAN_REPORTER_GITHUB_REPO="${INPUT_REPO}"
export LOXCAN_REPORTER_GITHUB_ISSUE_NUMBER="${INPUT_ISSUE_NUMBER}"
export LOXCAN_REPORTER_GITHUB_TOKEN="${INPUT_TOKEN}"

BRANCH_BASE="origin/${INPUT_BASE}"
BRANCH_HEAD="origin/${INPUT_HEAD}"

/app/bin/loxcan "${BRANCH_BASE}" "${BRANCH_HEAD}"
