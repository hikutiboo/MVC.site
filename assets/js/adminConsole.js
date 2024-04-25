let status = false,
    consoleTemplateRequest = new XMLHttpRequest(),
    consoleTemplate = '',
    consoleBase = "mvc.site >";

consoleTemplateRequest.open('get', "/assets/templates/console.html");
consoleTemplateRequest.send();

consoleTemplateRequest.addEventListener("load", () => {
    if (consoleTemplateRequest.status >= 200 && consoleTemplateRequest.status < 300) {
        consoleTemplate = consoleTemplateRequest.response;
        start()
    }
});

function start() {
    document.body.addEventListener('keyup', (e) => {
        if (e.code === 'F12' && e.ctrlKey) {
            consoleSwitcher();
            status = !status;
        }
    });
}

function consoleSwitcher() {
    if (status) {
        document.getElementById('screenLocker').remove();
        document.body.style.overflow = 'unset';
    } else {
        document.body.innerHTML += consoleTemplate;
        document.body.style.overflow = 'hidden';

        let consoleLine = document.getElementById("consoleLine"),
            consoleBody = document.getElementById("consoleBody");

        consoleBody.addEventListener('submit', e => e.preventDefault());
        consoleLine.addEventListener('keyup',
            (e) => {
                if (e.code === "Enter") runCommand(consoleBody, consoleLine);
            });
    }
}

function runCommand(consoleBody, consoleLine) {
    let consoleData = new FormData(consoleBody),
        prevConsoleLinesContainer = document.getElementById("prevConsoleLines"),
        execCommand = new XMLHttpRequest(),
        commandLineContainer = document.getElementById("commandLineContainer");

    commandLineContainer.style.display = 'none';
    prevConsoleLinesContainer.innerHTML += `<p class="console-task">${consoleBase} ${Object.fromEntries(consoleData).command}</p>`
    consoleLine.value = '';

    execCommand.open('POST', "/terminal/");
    execCommand.send(consoleData);
    execCommand.addEventListener("load", () => {
        if (execCommand.status >= 200 && execCommand.status < 300) {
            let result = JSON.parse(execCommand.response)["result"];

            result.forEach((row) => {
                prevConsoleLinesContainer.innerHTML += `<p class="console-response">> ${row}</p>`
            });
            prevConsoleLinesContainer.innerHTML += `<p class="console-empty">> </p>`

            commandLineContainer.style.display = 'block';
            consoleLine.scrollIntoView(false);
            consoleLine.focus();
        }
    });
}