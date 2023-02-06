import styles from './AuthLayout.module.scss'
import Logo from '../../../images/logo.webp'
import AppCard from '../AppCard/AppCard'

const AuthLayout = ({children}) => {
  return (
    <div className={styles.container}>
      <div className={styles.logoSection}>
        <img src={Logo} alt="Website logo" />
      </div>
      
      <div className={styles.content}>
        <AppCard>
          { children }
        </AppCard>
      </div>
    </div>
  )
}

export default AuthLayout