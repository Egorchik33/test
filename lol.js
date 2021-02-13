const div = document.getElementById('div')
//функция - событие клика при нажатии отображается текст
div.addEventListener('click',() =>{
    let arr = ['text1','text2','text3','text4','text5','text6','text7','text8']
    for (let i = 0; i < arr.length; i++){
        const text = document.getElementById(`${arr[i]}`)
        text.classList.toggle('show')
    }

})

