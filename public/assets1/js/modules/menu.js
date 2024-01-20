const createEntry = (datas, parent) => {
    datas.forEach((data) => {
        const li = document.createElement("li");
        li.classList.add("menuBtn")
        
        if (data.url !== null) {
            li.innerHTML = `<a href="http://127.0.0.1:8000/${data.url}">${data.text}</a>`;
        } else {
            li.textContent = data.text;
        }
        parent.append(li)
        if (data.icon !== null) {
            const icon = document.createElement("i");
            data.icon.forEach(element => {
                icon.classList.add(element);
            });
            li.prepend(icon);
        }
        if (data.subMenu !== null) {
            const ul = document.createElement("ul");
            li.addEventListener("click",()=>{
                ul.classList.toggle("hideSubMenu")
                ul.classList.toggle("showSubMenu")
            })
            ul.classList.add("subMenu","hideSubMenu")
            li.append(ul);
            createEntry(data.subMenu, ul)
        }
    })
}
export { createEntry }
