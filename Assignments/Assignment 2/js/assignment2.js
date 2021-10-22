/* add code here */
window.onload = () => {
    let addNoteBtn = document.getElementById('highlight');
    let hideNoteBtn = document.getElementById('hide');
    hideNoteBtn.style.visibility = 'hidden';

    addNoteBtn.addEventListener('click', function () {
        //const body = [...document.body.getElementsByTagName('*')];
        //const body = document.body.getElementsByTagName('*');
        //getElem is HTML Collection

        const body = document.querySelectorAll('*');
        //query is NodeList
        console.log(body);

        // for (let elem of body) {
        //     console.log(elem);
        //     createSpan(elem);
        // }

        body.forEach((elem) => {
            createSpan(elem);
        });

        //This function get the HTML tagName as an input
        // It will create a span with the tagName as text node and append to that tagName
        function createSpan(element) {
            let textNode = document.createTextNode(`${element.tagName}`);
            let span = document.createElement('span');

            span.appendChild(textNode);
            span.className = 'hoverNode';

            span.addEventListener('click', function () {
                alert(
                    `TAG: ${element.tagName}\nClass: ${element.className}\nID: ${element.id}\ninnerHTML: ${element.innerHTML}`
                );
            });

            element.appendChild(span);
        }
        addNoteBtn.style.visibility = 'hidden';
        hideNoteBtn.style.visibility = 'visible';
    });

    hideNoteBtn.addEventListener('click', function () {
        // First solution
        // const hoverNode = document.getElementsByClassName('hoverNode');
        // while (hoverNode.length > 0) {
        //     hoverNode[0].parentNode.removeChild(hoverNode[0]);
        // }

        //Second solution
        const hoverNode = document.querySelectorAll('.hoverNode');
        hoverNode.forEach((elem) => elem.remove());

        addNoteBtn.style.visibility = 'visible';
        hideNoteBtn.style.visibility = 'hidden';
    });
};
