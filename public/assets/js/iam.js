$(document).ready(function () {
    let words = [
        "Website Developer",
        "Programmer",
        "Fret Smasher",
        "Assistant Teacher",
        "Senior High School Student",
        "Discord Bot Developer",
        "PHP Fanatic",
        "18 years old"
    ]

    let iam = $("#iam > b")
    let iamV = $("#iam > span")
    let wordIterator = 0
    let word = words[wordIterator++]

    let characters = word.split("")
    let characterIterator = 0
    let deleting = vowelChecked = false

    setInterval(() => {
        if (deleting !== false) {
            return
        }

        if (!vowelChecked) {
            vowels = ["a", "e", "i", "o", "u"]

            if (vowels.includes(word.charAt(0).toLowerCase())) {
                iamV.text("I am an")
            } else if (word.charAt(0) != "1") {
                iamV.text("I am a")
            } else {
                iamV.text("I am")
            }

            vowelChecked = true
        }

        character = characters[characterIterator++]

        if (typeof character === "undefined") {
            vowelChecked = false

            deleting = true

            setTimeout(() => {
                deleting = setInterval(() => {
                    if (iam.text().slice(-1) === " ") {
                        iam.text(iam.text().slice(0, -1))
                    }

                    iam.text(iam.text().slice(0, -1))

                    if (!iam.text().length) {
                        if (typeof words[wordIterator] === "undefined") {
                            wordIterator = 0
                        }

                        clearInterval(deleting)
                        deleting = false
                    }
                }, 50)
            }, 300)

            word = words[wordIterator++]
            characters = word.split("")
            characterIterator = 0
            return
        }

        iam.text(iam.text() + character)
    }, 80   )
})