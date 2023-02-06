import { Route, Routes } from 'react-router-dom'
import '../css/app.css'
import Admin from './pages/admin/Admin'
import Client from './pages/client/Client'

function App() {
  return (
    <Routes>
      <Route path="/*" element={<Client />} />
      <Route path="/panel/*" element={<Admin />}  />
    </Routes>
  );
}

export default App;