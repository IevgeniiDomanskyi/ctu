import styles from './Login.module.scss'
import { useState } from 'react'
import { useNavigate } from "react-router-dom"

import AppTextField from '../../components/AppTextField/AppTextField'
import AppButton from '../../components/AppButton/AppButton'
import AppLink from '../../components/AppLink/AppLink'

const Recovery = () => {
  const navigate = useNavigate()

  const [form, setForm] = useState({email: '', password: '', confirmPassword: ''})

  const handlSubmitRecovery = () => {
    dispatch(userLogin({
      email: form.email,
      password: form.password,
      confirmPassword: form.confirmPassword,
    }))
  }

  const handleChange = field => value => {
    setForm(state => ({
      ...state,
      [field]: value,
    }))
  }

  const handleSubmit = value => {
    console.log('tyt?')
  }
  
  return (
    <div className={styles.container}>      
      <AppTextField
        type="email"
        label="Email Address"
        fullWidth
        onChange={handleChange('email')}
        value={form.email}
      />
      
      <AppTextField
        type="password"
        label="Password"
        fullWidth
        onChange={handleChange('password')}
        value={form.password}
      />

      <AppButton onClick={handleSubmit}>
        Reset password
      </AppButton>

      <AppLink withoutComponent onClick={() => navigate(-1)}>
        Go Back
      </AppLink>
    </div>
  )
}

export default Recovery