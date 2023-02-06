import styles from './Login.module.scss'
import { useState } from 'react'
import { useDispatch } from 'react-redux'
import { userLogin } from '@/store/auth'

import AppTextField from '../../components/AppTextField/AppTextField'
import AppButton from '../../components/AppButton/AppButton'
import AppLink from '../../components/AppLink/AppLink'

const Register = () => {
  const dispatch = useDispatch()

  const [form, setForm] = useState({name: '', email: '', password: '', company: ''})

  const handleSubmit = () => {
    dispatch(userLogin({
      email: 'id@div-art.com',
      password: '123123123',
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
        type="text"
        label="Your Name"
        fullWidth
        onChange={handleChange('name')}
        value={form.name}
      />
      
      <AppTextField
        type="text"
        label="Company Name"
        fullWidth
        onChange={handleChange('company')}
        value={form.company}
      />
      
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
        Register
      </AppButton>

      <div className={styles.loginFooter}>
        <AppLink to="/">Login</AppLink>
        <AppLink to="/recovery">Recovery</AppLink>
      </div>
    </div>
  )
}

export default Register