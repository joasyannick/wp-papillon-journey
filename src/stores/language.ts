import { watch } from 'vue'
import { usePreferredLanguages, useLocalStorage } from '@vueuse/core'
import { defineStore } from 'pinia'
import { EN_LANGUAGE, FR_LANGUAGE, LANGUAGE_KEY } from '@/constants'

const isValidLanguage = ( language: string ) => language === EN_LANGUAGE || language === FR_LANGUAGE
const validateLanguage = ( language: string ) => { return isValidLanguage( language ) ? language : EN_LANGUAGE }

export const useLanguageStore = defineStore( LANGUAGE_KEY, () => {
    const preferredLanguages = usePreferredLanguages().value.map( ( language ) => language.split( '-' )[ 0 ].toLowerCase() ).filter( isValidLanguage )
    const current = useLocalStorage( LANGUAGE_KEY, preferredLanguages.length ? preferredLanguages[ 0 ] : EN_LANGUAGE )
    const set = ( newLanguage: string ) => { current.value = validateLanguage( newLanguage ) }
    watch( current, ( newLanguage ) => { localStorage.setItem( LANGUAGE_KEY, newLanguage ) } )
    return { current, set }
  } )