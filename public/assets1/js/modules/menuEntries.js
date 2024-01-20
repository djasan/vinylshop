const menuEntries = [
    {
        text:"Catalogue Vinyl",
        url:"vinyl",
        icon:["fa-solid","fa-compact-disc"],
        subMenu:null
    },
    {
        text:"Vinyles de 1983",
        url:"user_vinyl",
        icon:["fa-solid","fa-music"],
        subMenu:null
    },
    {
        text:"Selection du moment",
        url:null,
        icon:["fa-solid","fa-caret-down"],
        subMenu:[
            {
                text:"Item1",
                url:null,
                icon:["fa-solid","fa-carrot"],
                subMenu:null
            },
            {
                text:"Item2",
                url:null,
                icon:["fa-regular","fa-lemon"],
                subMenu:null
            },
            {
                text:"Item3",
                url:null,
                icon:["fa-solid","fa-apple-whole"],
                subMenu:null
            },
            {
                text:"Item4",
                url:null,
                icon:["fa-solid","fa-pepper-hot"],
                subMenu:null
            },
            {
                text:"Item5",
                url:null,
                icon:["fa-solid","fa-leaf"],
                subMenu:null
            }
        ]
    },
]
export { menuEntries }