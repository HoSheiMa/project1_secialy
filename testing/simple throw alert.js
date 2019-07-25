<script>
    var children = []
            function formating_children() {

                for (; ;) {
                    if (children.length == 0) break;
    var focus_e = children.shift()
    delete children.shift()
    too(focus_e[0], focus_e[1]);
}
}

            function too(arr, father) {
                for (i in arr) {
                    var e = document.createElement('div')
                    if (arr[i].t) {
        e.innerText = arr[i].t;
    }
                    if (arr[i].c) {
        children.push([arr[i].c, e]);
    }
                    if (father) {
        father.appendChild(e)
    } else {
        document.body.appendChild(e);
    }


}
formating_children();

}

</script>