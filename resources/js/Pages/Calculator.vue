<script setup>
import CalculatorButton from "../Components/CalculatorButton.vue";
import {ref} from "vue";
import axios from "axios";

const display = ref('0');
const history = ref([]);

const operators = ['+', '-', '*', '/'];

const remove = () => {
    if (display.value) {
        display.value = display.value.slice(0, display.value.length -1);
    }

    if (display.value.length < 1) {
        display.value = '0';
    }
}

const append = (character) => {
    if (operators.includes(character) && operators.includes(display.value.slice(-1))) {
        return;
    }

    if (display.value === '0' && character !== '.') {
        display.value = character;
    } else {
        display.value += character;
    }
}

const clear = () => {
    display.value = '0';
}

const submit = async () => {
    if (operators.includes(display.value.slice(-1))) {
        return;
    }

    await axios.post(route('calculate'), {
        'equation': display.value
    }).then(res => {
        addToHistory();
        display.value = res.data.result;
    })
}

const addToHistory = () => {
    history.value.push(display.value);
}

const removeFromHistory = (index) => {
    history.value.splice(index, 1);
}

const jumpToHistory = (index) => {
    display.value = history.value[index];
}
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="rounded-2xl grid w-full max-w-[16rem] bg-gray-900 px-2 shadow-lg border-2 border-gray-500">
            <div class="flex flex-col h-32 w-full items-end justify-end overflow-hidden">
                <div class="flex items-center space-x-2 w-full overflow-x-scroll mb-2 h-12">
                    <template v-for="(history, index) in history">
                        <div @click="jumpToHistory(index)" class="px-2 text-sm rounded-full border border-gray-700 text-gray-400 inline-flex items-center justify-center hover:border-neutral-400 cursor-pointer">
                            <button @click="removeFromHistory(index)" class="text-xs mr-1 hover:text-red-500">x</button>
                            {{ history }}
                        </div>
                    </template>
                </div>
                <div v-text="display" class="text-4xl font-bold font-mono text-white"></div>
            </div>

            <div class="grid grid-cols-4 gap-2 w-full p-2">
                <CalculatorButton @click="clear" class="col-span-2 bg-gray-400 text-gray-900">
                    AC
                </CalculatorButton>
                <CalculatorButton @click="remove" class="bg-orange-400 text-orange-50">
                    DEL
                </CalculatorButton>
                <CalculatorButton @click="append('/')" class="bg-orange-400 text-orange-50">
                    &divide;
                </CalculatorButton>
                <CalculatorButton @click="append('7')" class="bg-gray-400 text-gray-900">
                    7
                </CalculatorButton>
                <CalculatorButton @click="append('8')" class="bg-gray-400 text-gray-900">
                    8
                </CalculatorButton>
                <CalculatorButton @click="append('9')" class="bg-gray-400 text-gray-900">
                    9
                </CalculatorButton>
                <CalculatorButton @click="append('*')" class="bg-orange-400 text-orange-50">
                    &times;
                </CalculatorButton>
                <CalculatorButton @click="append('4')" class="bg-gray-400 text-gray-900">
                    4
                </CalculatorButton>
                <CalculatorButton @click="append('5')" class="bg-gray-400 text-gray-900">
                    5
                </CalculatorButton>
                <CalculatorButton @click="append('6')" class="bg-gray-400 text-gray-900">
                    6
                </CalculatorButton>
                <CalculatorButton @click="append('-')" class="bg-orange-400 text-orange-50">
                    &minus;
                </CalculatorButton>
                <CalculatorButton @click="append('1')" class="bg-gray-400 text-gray-900">
                    1
                </CalculatorButton>
                <CalculatorButton @click="append('2')" class="bg-gray-400 text-gray-900">
                    2
                </CalculatorButton>
                <CalculatorButton @click="append('3')" class="bg-gray-400 text-gray-900">
                    3
                </CalculatorButton>
                <CalculatorButton @click="append('+')" class="bg-orange-400 text-orange-50">
                    &plus;
                </CalculatorButton>
                <CalculatorButton @click="append('0')" class="col-span-2 text-left bg-gray-400 text-gray-900">
                    0
                </CalculatorButton>
                <CalculatorButton @click="append('.')" class="bg-gray-400 text-gray-900">
                    &dot;
                </CalculatorButton>
                <CalculatorButton @click="submit" class="bg-orange-400 text-orange-50">
                    &equals;
                </CalculatorButton>
            </div>
        </div>
    </div>
</template>
