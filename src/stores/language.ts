import { watch } from 'vue'
import { usePreferredLanguages, useLocalStorage } from '@vueuse/core'
import { defineStore } from 'pinia'
import { EN_LANGUAGE, FR_LANGUAGE, LANGUAGE_KEY } from '@/constants'

const isValidLanguage = ( language: string ) => language === EN_LANGUAGE || language === FR_LANGUAGE
const validateLanguage = ( language: string ) => { return isValidLanguage( language ) ? language : EN_LANGUAGE }

export const useLanguageStore = defineStore( LANGUAGE_KEY, () => {
    const preferredLanguages = usePreferredLanguages().value.map( ( language ) => language.split( '-' )[ 0 ].toLowerCase() ).filter( isValidLanguage )
    const language = useLocalStorage( LANGUAGE_KEY, preferredLanguages.length ? preferredLanguages[ 0 ] : EN_LANGUAGE )
    const setLanguage = ( newLanguage: string ) => { language.value = validateLanguage( newLanguage ) }
    watch( language, ( newLanguage ) => { localStorage.setItem( LANGUAGE_KEY, newLanguage ) } )
    return { language, setLanguage }
  } )