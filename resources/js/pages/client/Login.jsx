import styles from './Login.module.scss'
import { useState } from 'react'
import { useDispatch } from 'react-redux'
import { userLogin } from '@/store/auth'

import AppTextField from '../../components/AppTextField/AppTextField'
import AppButton from '../../components/AppButton/AppButton'
import AppLink from '../../components/AppLink/AppLink'

const Login = () => {
  const dispatch = useDispatch()

  const [form, setForm] = useState({email: '', password: ''})

  const handleSubmit = () => {
    dispatch(userLogin({
      email: form.email,
      password: form.password,
    }))
  }

  const handleChange = field => value => {
    setForm(state => ({
      ...state,
      [field]: value,
    }))
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
        Log In
      </AppButton>
      
      <div className={styles.loginFooter}>
        <AppLink to="/register">Register</AppLink>
        <AppLink to="/recovery">Recovery</AppLink>
      </div>
    </div>
  )
}

export default Login