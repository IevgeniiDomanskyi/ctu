import Link from '@mui/material/Link'
import { Link as RouterLink } from 'react-router-dom'

const AppLink = ({children, to = null, withoutComponent = false, underline = 'hover', onClick, ...props}) => {
  return (
    <Link
      component={withoutComponent ? null : RouterLink}
      onClick={withoutComponent ? () => onClick() : null}
      to={to}
      underline={underline}
      {...props}
    >
      { children }
    </Link>
  )
}

export default AppLink