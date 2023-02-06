import { Route, Routes } from 'react-router-dom'
import AuthLayout from '@/components/AuthLayout/AuthLayout'
import Login from './Login'
import Register from './Register'
import Recovery from './Recovery'

const LoginLayout = () => {
  console.log('LoginLayout')
  return (
    <AuthLayout>
      <Routes>
        <Route path="/register" element={<Register />} />
        <Route path="/recovery" element={<Recovery />} />
        <Route path="*" element={<Login />} />
      </Routes>
    </AuthLayout>
  );
}

export default LoginLayout;