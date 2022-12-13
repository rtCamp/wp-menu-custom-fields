#!/usr/bin/env node
// Octokit.js
// https://github.com/octokit/core.js#readme

const { Octokit } = require("@octokit/core");

const octokit = new Octokit({
    auth: process.env.TOKEN,
});

octokit.request("POST /repos/{org}/{repo}/statuses/{sha}", {
    org: "rtCamp",
    repo: "wp-menu-custom-fields",
    sha: process.env.SHA ? process.env.SHA : process.env.COMMIT_SHA,
    state: "success",
    conclusion: "success",
    target_url:
        "https://www.tesults.com/results/rsp/view/results/project/0cf2aaec-c944-4b1e-afd9-7cd4bd2e49a1",
    description: "Successfully synced to Tesults",
    context: "E2E Test Result",
});