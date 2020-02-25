(function () {
    var dndHandler = {
        draggedElement: null,
        applyDragEvents: function(element) {
            element.draggable = true;

            var dndHandler = this;

            element.addEventListener('dragstart', function(e) {
                dndHandler.draggedElement = e.target;
                e.dataTransfer.setData('text/plain', '');
            })
        },

        applyDropEvents: function(dropper) {
            dropper.addEventListener('dragover', function(e) {
                e.preventDefault();
                // dropper.style.borderStyle = 'dashed'; 
                this.className = 'dropper drop_hover';
            });
            dropper.addEventListener('dragleave', function() {
                // dropper.style.borderStyle = 'solid'; 

                this.classname = 'dropper';
            });
            var dndHandler = this;
            dropper.addEventListener('drop', function(e) { // ici il faut transformer la div en input pour pouvoir traiter les données comme un formulaire
                                                            // et récupérer aussi le nom du stand pour pouvoir ensuite update la participation avec le stall, le vol et le slot
                var target = e.target,
                    draggedElement = dndHandler.draggedElement,
                    clonedElement = draggedElement.cloneNode(true);
                while (target.className.indexOf('dropper') == -1) {
                    target = target.parentNode;
                }
                
                target.className = 'dropper';
                clonedElement = target.appendChild(clonedElement);
                dndHandler.applyDragEvents(clonedElement);
                draggedElement.parentNode.removeChild(draggedElement);
                update(draggedElement.textContent);
                console.log(draggedElement.textContent);

            });
           
        }
    };


    var elements = document.querySelectorAll('.draggable'),
        elementsLen = elements.length;
    for (var i = 0; i < elementsLen; i++) {
        dndHandler.applyDragEvents(elements[i]);
    }

    var droppers = document.querySelectorAll('.dropper'),
        droppersLen = droppers.length;
        for (var i = 0; i < droppersLen; i++) {
            dndHandler.applyDropEvents(droppers[i]);
        }

})();

function update(data) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/schedule');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.addEventListener('readystatechange', function() {
        if (xhr.readyState === 4 && xhr.status === 200 || xhr.status === 0) {
            console.log(data);
        } else {
            console.log('NOK');
        }
    });
    xhr.send("var="+data);
}
