import { ref } from 'vue'

export default function useValidationRules() {
  const rules = {
    required: value => !!value || 'This field is required.',
    arabicLetters: value => /^[؀-ۿ ]+$/.test(value) || 'The field should contain only Arabic letters.',
    englishLetters: value => /^[A-Za-z ]+$/.test(value) || 'The field should contain only English letters.',
    email: value => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) || 'The field should be valid email.',
    nullable: value => value !== null && value !== undefined || 'This field can be null or undefined.',
    numeric: value => !isNaN(parseFloat(value)) && isFinite(value) || 'This field must be a number.',
    string: value => typeof value === 'string' || 'This field must be a string.',
    boolean: value => typeof value === 'boolean' || value === 0 || value === 1 || 'This field must be a boolean or 0/1.',
    array: value => Array.isArray(value) || typeof value === 'object' || 'This field must be an array or an object.',
  }

  const maxRule = max => value => {
    if (typeof value === 'string') {
      return value.length <= max || `This field must be at most ${max} characters long.`
    } else if (typeof value === 'number') {
      const digits = String(value).replace('.', '').length

      return digits <= max || `This field must have at most ${max} digits.`
    }

    return true
  }

  const minRule = min => value => {
    if (typeof value === 'string') {
      return value.length >= min || `This field must be at least ${min} characters long.`
    } else if (typeof value === 'number') {
      const digits = String(value).replace('.', '').length

      return digits >= min || `This field must have at least ${min} digits.`
    }

    return true
  }

  const errors = ref({})

  const validateForm = (form, validationRules) => {
    let isValid = true

    validationRules.forEach(({ property, rules }) => {
      const value = form.value[property]

      let skipRemainingRules = false

      rules.forEach(rule => {
        if (skipRemainingRules) {
          return
        }

        let ruleFunction
        let errorMessage

        if (typeof rule === 'function') {
          ruleFunction = rule
          errorMessage = rule(value)
        } else if (typeof rule === 'object' && typeof rule.rule === 'function') {
          ruleFunction = rule.rule
          errorMessage = rule.message || 'Validation error'
        }

        if (typeof ruleFunction === 'function') {
          const result = ruleFunction(value)
          if (result !== true) {
            if (rules.some(r => r.name === 'nullable') && (value === null || value === undefined || value === '')) {
              skipRemainingRules = true
            } else {
              errors.value[property] = errorMessage || result
              isValid = false
              if (ruleFunction.name === 'required') {
                skipRemainingRules = true
              }
            }
          }
        }
      })
    })

    console.log(errors.value)

    return isValid
  }

  return { rules, maxRule, minRule, errors, validateForm }
}
